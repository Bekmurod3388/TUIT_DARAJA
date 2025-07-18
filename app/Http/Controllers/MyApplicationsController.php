<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Specalization;
use App\Http\Requests\ApplicationRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MyApplicationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $applications = $user->applications()->with('specalization')->get();
        $specalizations = \App\Models\Specalization::where('is_visible', true)->with('subjects')->get();
        return view('my-applications', compact('user', 'applications', 'specalizations'));
    }

    public function create()
    {
        $user = Auth::user();
        $specalizations = Specalization::where('is_visible', true)->get();
        return view('my-applications', compact('user', 'specalizations'));
    }

    public function store(ApplicationRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $userId = $user->id;
        $timestamp = now()->timestamp;
        $oacPath = $request->file('oac_file') ? $request->file('oac_file')->storeAs('applications/oac', $userId.'_'.$timestamp.'_oac.'.$request->file('oac_file')->getClientOriginalExtension(), 'public') : null;
        $directionPath = $request->file('direction_file') ? $request->file('direction_file')->storeAs('applications/direction', $userId.'_'.$timestamp.'_direction.'.$request->file('direction_file')->getClientOriginalExtension(), 'public') : null;
        $receiptPath = $request->file('receipt_file') ? $request->file('receipt_file')->storeAs('applications/receipt', $userId.'_'.$timestamp.'_receipt.'.$request->file('receipt_file')->getClientOriginalExtension(), 'public') : null;
        $workOrderPath = $request->file('work_order_file') ? $request->file('work_order_file')->storeAs('applications/work_order', $userId.'_'.$timestamp.'_workorder.'.$request->file('work_order_file')->getClientOriginalExtension(), 'public') : null;

        if (($data['organization_type'] ?? null) === 'uzmu') {
            $data['organization'] = 'TATU';
        }

        $application = new \App\Models\Application();
        $application->user_id = $user->id;
        $application->specalization_id = $data['specalization_id'];
        $application->organization = $data['organization'] ?? '';
        $application->subject = $data['subject'] ?? '';
        $application->status = 'pending';
        $application->last_name = $data['last_name'];
        $application->first_name = $data['first_name'];
        $application->middle_name = $data['middle_name'];
        $application->phone = $data['phone'] ?? '';
        $application->education_type = $data['education_type'] ?? '';
        $application->oac_file = $oacPath;
        $application->direction_file = $directionPath;
        $application->receipt_file = $receiptPath;
        $application->work_order_file = $workOrderPath;
        $application->save();

        return redirect()->route('my.applications')->with('success', 'Ariza muvaffaqiyatli yuborildi!');
    }

    public function edit($id)
    {
        $application = \App\Models\Application::findOrFail($id);
        $specalizations = \App\Models\Specalization::all();
        return view('edit-application', compact('application', 'specalizations'));
    }

    public function update(Request $request, $id)
    {
        $application = \App\Models\Application::findOrFail($id);
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'specalization_id' => 'required|exists:specalizations,id',
            'subject' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
        ]);
        $application->update($validated);
        return redirect()->route('my.applications')->with('success', 'Ariza muvaffaqiyatli yangilandi!');
    }

    // Payme to'lovini boshlash
    public function pay($id)
    {
        $application = \App\Models\Application::findOrFail($id);
        if ($application->payment_status === 'paid') {
            return redirect()->route('my.applications')->with('success', 'To‘lov allaqachon amalga oshirilgan!');
        }
        $amount = $application->specalization->price * 100; // so'm -> tiyin
        $merchant_id = config('services.payme.merchant_id');
        $callback_url = config('services.payme.callback_url');
        // Payme payment linkini generatsiya qilish (soddalashtirilgan)
        $payme_url = "https://checkout.paycom.uz/" .
            "?merchant=$merchant_id" .
            "&amount=$amount" .
            "&account[order_id]={$application->id}" .
            "&callback=$callback_url";
        return redirect($payme_url);
    }

    // Payme callback (notification)
    public function paymeCallback(Request $request)
    {
        $orderId = $request->input('account.order_id');
        $application = \App\Models\Application::find($orderId);
        if ($application) {
            $application->payment_status = 'paid';
            $application->save();
        }
        return response()->json(['result' => 'ok']);
    }

    public function certificate($id)
    {
        $application = \App\Models\Application::with('specalization')->findOrFail($id);
        $user = Auth::user();
        // Only owner or admin can download
        if (!($user->id === $application->user_id || in_array($user->role, ['admin', 'superadmin']))) {
            abort(403, 'Sizda bu sertifikatni yuklab olish huquqi yo‘q!');
        }
        if (!$application->is_scored) {
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
}
