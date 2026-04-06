<?php

namespace App\Http\Controllers;

use App\Exceptions\PaymeException;
use App\Models\Application;
use App\Models\AuditLog;
use App\Models\PaymeTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PaymeController extends Controller
{
    private const STATE_CREATED = 1;
    private const STATE_COMPLETED = 2;
    private const STATE_CANCELLED_AFTER_CREATE = -1;
    private const STATE_CANCELLED_AFTER_COMPLETE = -2;
    private const TIMEOUT_MS = 43200000;

    public function return(): RedirectResponse
    {
        return redirect()->route('my.applications')->with(
            'success',
            'To‘lov holati Payme tomonidan tasdiqlangach yangilanadi.'
        );
    }

    private const PAYME_IPS = [
        '185.178.51.131',
        '185.178.51.132',
        '195.158.11.134',
        '195.158.28.124',
        '195.158.31.134',
        '195.158.31.10',
    ];

    public function merchant(Request $request): JsonResponse
    {
        $payload = $request->json()->all();
        $id = $payload['id'] ?? null;

        if (app()->isProduction() && !in_array($request->ip(), self::PAYME_IPS, true)) {
            return response()->json([
                'id' => $id,
                'error' => [
                    'code' => -32504,
                    'message' => 'IP not allowed',
                ],
            ], 403);
        }

        if (!$this->isAuthorized($request)) {
            return response()->json([
                'id' => $id,
                'error' => [
                    'code' => -32504,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        }

        try {
            $result = match ($payload['method'] ?? null) {
                'CheckPerformTransaction' => $this->checkPerformTransaction($payload['params'] ?? []),
                'CreateTransaction' => $this->createTransaction($payload['params'] ?? []),
                'PerformTransaction' => $this->performTransaction($payload['params'] ?? []),
                'CancelTransaction' => $this->cancelTransaction($payload['params'] ?? []),
                'CheckTransaction' => $this->checkTransaction($payload['params'] ?? []),
                'GetStatement' => $this->getStatement($payload['params'] ?? []),
                'SetFiscalData' => ['success' => true],
                default => throw new PaymeException(-32601, 'Method not found'),
            };

            return response()->json([
                'id' => $id,
                'result' => $result,
            ]);
        } catch (PaymeException $e) {
            return response()->json([
                'id' => $id,
                'error' => $e->toArray(),
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'id' => $id,
                'error' => [
                    'code' => -32400,
                    'message' => 'System error',
                ],
            ], 500);
        }
    }

    private function checkPerformTransaction(array $params): array
    {
        $application = $this->resolveApplication($params);

        if ($application->payment_status === 'paid') {
            throw new PaymeException(-31008, 'Operation cannot be performed');
        }

        return ['allow' => true];
    }

    private function createTransaction(array $params): array
    {
        $paymeTransactionId = (string) ($params['id'] ?? '');
        $paymeTime = (int) ($params['time'] ?? 0);

        if ($paymeTransactionId === '' || $paymeTime <= 0) {
            throw new PaymeException(-32602, 'Invalid params');
        }

        return DB::transaction(function () use ($params, $paymeTransactionId, $paymeTime): array {
            $application = $this->resolveApplication($params, true);

            $existingTransaction = PaymeTransaction::query()
                ->lockForUpdate()
                ->where('payme_transaction_id', $paymeTransactionId)
                ->first();

            if ($existingTransaction) {
                return $this->transactionPayload($existingTransaction);
            }

            $activeTransaction = PaymeTransaction::query()
                ->lockForUpdate()
                ->where('application_id', $application->id)
                ->where('state', self::STATE_CREATED)
                ->latest('id')
                ->first();

            if ($activeTransaction) {
                if (($paymeTime - (int) $activeTransaction->payme_time) >= self::TIMEOUT_MS) {
                    $this->cancelStoredTransaction($activeTransaction, 4, $application);
                } else {
                    throw new PaymeException(-31008, 'Operation cannot be performed');
                }
            }

            $transaction = PaymeTransaction::create([
                'payme_transaction_id' => $paymeTransactionId,
                'application_id' => $application->id,
                'amount' => $params['amount'],
                'state' => self::STATE_CREATED,
                'payme_time' => $paymeTime,
                'create_time' => now(),
            ]);

            if ($application->payment_status !== 'pending') {
                $application->update(['payment_status' => 'pending']);
            }

            return $this->transactionPayload($transaction);
        }, 3);
    }

    private function performTransaction(array $params): array
    {
        return DB::transaction(function () use ($params): array {
            $transaction = $this->findTransaction((string) ($params['id'] ?? ''), true);

            if ($transaction->state === self::STATE_COMPLETED) {
                return $this->transactionPayload($transaction);
            }

            if ($transaction->state !== self::STATE_CREATED) {
                throw new PaymeException(-31008, 'Operation cannot be performed');
            }

            $application = Application::query()
                ->lockForUpdate()
                ->findOrFail($transaction->application_id);

            if (($this->currentTimeMs() - (int) $transaction->payme_time) >= self::TIMEOUT_MS) {
                $this->cancelStoredTransaction($transaction, 4, $application);
                throw new PaymeException(-31008, 'Operation cannot be performed');
            }

            $previousPaymentStatus = $application->payment_status;

            $transaction->forceFill([
                'state' => self::STATE_COMPLETED,
                'perform_time' => now(),
            ])->save();

            $application->update(['payment_status' => 'paid']);

            AuditLog::record('payment_completed', $application, ['payment_status' => $previousPaymentStatus], ['payment_status' => 'paid']);

            return $this->transactionPayload($transaction->fresh());
        }, 3);
    }

    private function cancelTransaction(array $params): array
    {
        return DB::transaction(function () use ($params): array {
            $transaction = $this->findTransaction((string) ($params['id'] ?? ''), true);

            if (in_array($transaction->state, [self::STATE_CANCELLED_AFTER_CREATE, self::STATE_CANCELLED_AFTER_COMPLETE], true)) {
                return $this->transactionPayload($transaction);
            }

            $application = Application::query()
                ->lockForUpdate()
                ->findOrFail($transaction->application_id);

            $this->cancelStoredTransaction($transaction, (int) ($params['reason'] ?? 0), $application);

            return $this->transactionPayload($transaction->fresh());
        }, 3);
    }

    private function checkTransaction(array $params): array
    {
        return $this->transactionPayload(
            $this->findTransaction((string) ($params['id'] ?? ''))
        );
    }

    private function getStatement(array $params): array
    {
        $from = (int) ($params['from'] ?? 0);
        $to = (int) ($params['to'] ?? 0);

        $transactions = PaymeTransaction::query()
            ->whereBetween('payme_time', [$from, $to])
            ->get()
            ->map(fn (PaymeTransaction $transaction) => $this->transactionPayload($transaction))
            ->all();

        return ['transactions' => $transactions];
    }

    private function resolveApplication(array $params, bool $forUpdate = false): Application
    {
        $orderId = data_get($params, 'account.order_id');
        $amount = (int) ($params['amount'] ?? 0);

        $query = Application::query()->with('specalization');

        if ($forUpdate) {
            $query->lockForUpdate();
        }

        $application = $query->find($orderId);

        if (!$application) {
            throw new PaymeException(
                -31050,
                [
                    'ru' => 'Неверный код заказа.',
                    'uz' => 'Buyurtma kodi noto‘g‘ri.',
                    'en' => 'Incorrect order code.',
                ],
                'order_id'
            );
        }

        if (!$application->specalization || $application->specalization->price * 100 !== $amount) {
            throw new PaymeException(-31001, 'Incorrect amount');
        }

        return $application;
    }

    private function findTransaction(string $paymeTransactionId, bool $forUpdate = false): PaymeTransaction
    {
        $query = PaymeTransaction::query()
            ->where('payme_transaction_id', $paymeTransactionId);

        if ($forUpdate) {
            $query->lockForUpdate();
        }

        $transaction = $query->first();

        if (!$transaction) {
            throw new PaymeException(-31003, 'Transaction not found');
        }

        return $transaction;
    }

    private function cancelStoredTransaction(PaymeTransaction $transaction, int $reason, ?Application $application = null): void
    {
        $cancelledState = $transaction->state === self::STATE_COMPLETED
            ? self::STATE_CANCELLED_AFTER_COMPLETE
            : self::STATE_CANCELLED_AFTER_CREATE;

        $application ??= $transaction->application()->lockForUpdate()->firstOrFail();

        $transaction->forceFill([
            'state' => $cancelledState,
            'reason' => $reason,
            'cancel_time' => now(),
        ])->save();

        $application->update(['payment_status' => 'pending']);
    }

    private function transactionPayload(PaymeTransaction $transaction): array
    {
        return [
            'create_time' => $this->toTimestampMs($transaction->create_time),
            'perform_time' => $this->toTimestampMs($transaction->perform_time),
            'cancel_time' => $this->toTimestampMs($transaction->cancel_time),
            'transaction' => (string) $transaction->id,
            'state' => $transaction->state,
            'reason' => $transaction->reason,
        ];
    }

    private function isAuthorized(Request $request): bool
    {
        $authorization = (string) $request->header('Authorization', '');

        if (!str_starts_with($authorization, 'Basic ')) {
            return false;
        }

        $decoded = base64_decode(substr($authorization, 6), true);

        if ($decoded === false || !str_contains($decoded, ':')) {
            return false;
        }

        [$login, $key] = explode(':', $decoded, 2);

        return hash_equals((string) config('services.payme.login'), $login)
            && hash_equals((string) config('services.payme.key'), $key);
    }

    private function currentTimeMs(): int
    {
        return (int) round(microtime(true) * 1000);
    }

    private function toTimestampMs(Carbon|string|null $value): int
    {
        if ($value === null) {
            return 0;
        }

        return ($value instanceof Carbon ? $value : Carbon::parse($value))->getTimestampMs();
    }
}
