<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Specalization;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Subject;

class MyApplicationsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $activeAcademicYear = $this->activeAcademicYear();
        $filters = [
            'academic_year_name' => $request->string('academic_year_name')->toString(),
            'semester' => $request->string('semester')->toString(),
        ];

        $applications = $user->applications()
            ->with(['specalization', 'academicYear'])
            ->when($filters['academic_year_name'] !== '', function ($query) use ($filters) {
                $query->whereHas('academicYear', fn ($academicYearQuery) => $academicYearQuery
                    ->where('name', $filters['academic_year_name']));
            })
            ->when($filters['semester'] !== '', function ($query) use ($filters) {
                $query->whereHas('academicYear', fn ($academicYearQuery) => $academicYearQuery
                    ->where('semester', $filters['semester']));
            })
            ->latest()
            ->get();

        $hasSpecalizations = Specalization::query()
            ->where('is_visible', true)
            ->when($activeAcademicYear, fn ($query) => $query->where('academic_year_id', $activeAcademicYear->id))
            ->exists();
        $hasAcademicYears = AcademicYear::query()->where('is_active', true)->exists();
        $canCreateApplication = $hasSpecalizations && $hasAcademicYears;
        $academicYearNames = AcademicYear::query()
            ->select('name')
            ->distinct()
            ->orderByDesc('name')
            ->pluck('name');

        return view('my-applications', compact(
            'user',
            'applications',
            'hasSpecalizations',
            'hasAcademicYears',
            'canCreateApplication',
            'academicYearNames',
            'filters',
            'activeAcademicYear'
        ));
    }

    public function create()
    {
        $user = Auth::user();
        $applications = collect();
        $activeAcademicYear = $this->activeAcademicYear();
        $hasSpecalizations = Specalization::query()
            ->where('is_visible', true)
            ->when($activeAcademicYear, fn ($query) => $query->where('academic_year_id', $activeAcademicYear->id))
            ->exists();
        $hasAcademicYears = AcademicYear::query()->where('is_active', true)->exists();
        $canCreateApplication = $hasSpecalizations && $hasAcademicYears;
        $academicYearNames = AcademicYear::query()
            ->select('name')
            ->distinct()
            ->orderByDesc('name')
            ->pluck('name');
        $filters = ['academic_year_name' => '', 'semester' => ''];

        return view('my-applications', compact(
            'user',
            'applications',
            'hasSpecalizations',
            'hasAcademicYears',
            'canCreateApplication',
            'academicYearNames',
            'filters',
            'activeAcademicYear'
        ));
    }

    public function specalizations(): JsonResponse
    {
        $specalizations = Specalization::query()
            ->with('academicYear')
            ->where('is_visible', true)
            ->whereHas('academicYear', fn ($query) => $query->where('is_active', true))
            ->select('id', 'name')
            ->orderBy('name')
            ->orderBy('id')
            ->get()
            ->groupBy(fn ($specalization) => $this->normalizeDisplayValue($specalization->name))
            ->map(fn ($group) => $group->first())
            ->values();

        return response()->json([
            'specalizations' => $specalizations->map(fn ($specalization) => [
                'id' => $specalization->id,
                'name' => $specalization->name,
            ])->values(),
        ]);
    }

    public function store(ApplicationRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $userId = $user->id;
        $specalization = Specalization::query()
            ->whereKey($data['specalization_id'])
            ->where('is_visible', true)
            ->whereHas('academicYear', fn ($query) => $query->where('is_active', true))
            ->firstOrFail();

        $files = ['oac_file', 'direction_file', 'receipt_file', 'work_order_file'];
        $paths = [];

        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $folder = str_replace('_file', '', $fileKey);
                $filename = implode('_', [
                    $userId,
                    now()->format('YmdHisv'),
                    Str::uuid()->toString(),
                    $folder,
                ]).'.'.$file->getClientOriginalExtension();

                $paths[$fileKey] = $file->storeAs(
                    "applications/$folder",
                    $filename,
                    'local'
                );
            } else {
                $paths[$fileKey] = null;
            }
        }

        if (($data['organization_type'] ?? null) === 'uzmu') {
            $data['organization'] = 'TATU';
        }

        $application = new \App\Models\Application();
        $application->user_id = $userId;
        $application->specalization_id = $specalization->id;
        $application->academic_year_id = $specalization->academic_year_id;
        $application->organization = $data['organization'] ?? '';
        $application->subject = $data['subject'] ?? '';
        $application->status = 'pending';
        $application->last_name = $data['last_name'];
        $application->first_name = $data['first_name'];
        $application->middle_name = $data['middle_name'];
        $application->phone = $data['phone'] ?? '';
        $application->education_type = $data['education_type'] ?? '';

        foreach ($paths as $key => $path) {
            $application->$key = $path;
        }

        $application->save();

        return redirect()->route('my.applications')->with('success', 'Ariza muvaffaqiyatli yuborildi!');
    }

    public function edit($id)
    {
        $application = $this->ownerApplicationQuery()->findOrFail($id);
        $specalizations = \App\Models\Specalization::all();
        return view('edit-application', compact('application', 'specalizations'));
    }

    public function update(UpdateApplicationRequest $request, $id)
    {
        $application = $this->ownerApplicationQuery()->findOrFail($id);
        $application->update($request->validated());
        return redirect()->route('my.applications')->with('success', 'Ariza muvaffaqiyatli yangilandi!');
    }

    public function subjects(int $specalizationId): JsonResponse
    {
        $specalization = Specalization::query()
            ->where('is_visible', true)
            ->whereHas('academicYear', fn ($query) => $query->where('is_active', true))
            ->select('id', 'name')
            ->findOrFail($specalizationId);

        $relatedSpecalizationIds = Specalization::query()
            ->where('is_visible', true)
            ->whereHas('academicYear', fn ($query) => $query->where('is_active', true))
            ->whereRaw('LOWER(TRIM(name)) = ?', [$this->normalizeDisplayValue($specalization->name)])
            ->orderBy('id')
            ->pluck('id');

        $subjects = Subject::query()
            ->select('subjects.fan_id', 'subjects.fan')
            ->join('specalization_subject', 'specalization_subject.subject_id', '=', 'subjects.fan_id')
            ->whereIn('specalization_subject.specalization_id', $relatedSpecalizationIds)
            ->orderBy('subjects.fan')
            ->get()
            ->unique(fn ($subject) => $this->normalizeDisplayValue($subject->fan))
            ->values();

        return response()->json([
            'subjects' => $subjects->map(fn ($subject) => [
                'id' => $subject->fan_id,
                'name' => $subject->fan,
            ])->values(),
        ]);
    }

    // Payme to'lovini boshlash
    public function pay($id)
    {
        $application = $this->ownerApplicationQuery()->with('specalization')->findOrFail($id);
        if ($application->payment_status === 'paid') {
            return redirect()->route('my.applications')->with('success', 'To‘lov allaqachon amalga oshirilgan!');
        }

        if (!$application->specalization || $application->specalization->price <= 0) {
            throw new HttpException(422, 'To‘lov summasi aniqlanmadi.');
        }

        $amount = $application->specalization->price * 100; // so'm -> tiyin

        $paymeUrl = 'https://checkout.paycom.uz/'.http_build_query([
            'merchant' => config('services.payme.merchant_id'),
            'amount' => $amount,
            'account' => [
                'order_id' => $application->id,
            ],
            'callback' => config('services.payme.callback_url') ?: route('payme.return'),
        ]);

        return redirect()->away($paymeUrl);
    }

    public function certificate($id)
    {
        $application = \App\Models\Application::with('specalization')->findOrFail($id);
        $user = Auth::user();
        // Only owner or admin can download
        if (!($user->id === $application->user_id || in_array($user->role, ['admin', 'superadmin']))) {
            abort(403, 'Sizda bu sertifikatni yuklab olish huquqi yo‘q!');
        }
        if (
            !$application->is_scored
            || $application->payment_status !== 'paid'
            || $application->status !== 'accepted'
        ) {
            abort(403, 'Sertifikat faqat baholangan arizalar uchun!');
        }
        $qrData = [
            'id' => $application->id,
            'fio' => $application->last_name.' '.$application->first_name.' '.$application->middle_name,
            'score' => $application->score,
            'spec' => $application->specalization->name ?? '',
            'date' => $application->updated_at->format('Y-m-d'),
        ];
        $qrSvg = QrCode::format('svg')->size(120)->generate(json_encode($qrData));
        $pdf = Pdf::loadView('certificate', [
            'application' => $application,
            'qrSvg' => $qrSvg,
        ]);
        return $pdf->download('sertifikat_'.$application->id.'.pdf');
    }

    public function downloadFile($id, $field)
    {
        $allowedFields = ['oac_file', 'direction_file', 'receipt_file', 'work_order_file'];

        if (!in_array($field, $allowedFields, true)) {
            abort(404);
        }

        $application = Application::findOrFail($id);
        $user = Auth::user();

        if (!($user->id === $application->user_id || in_array($user->role, ['admin', 'superadmin'], true))) {
            abort(403);
        }

        $path = $application->{$field};

        if (!$path || !Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path);
    }

    private function ownerApplicationQuery()
    {
        return Application::query()->where('user_id', Auth::id());
    }

    private function activeAcademicYear(): ?AcademicYear
    {
        return AcademicYear::query()
            ->where('is_active', true)
            ->first();
    }

    private function normalizeDisplayValue(?string $value): string
    {
        return mb_strtolower(trim((string) $value));
    }
}
