<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Specalization;
use App\Http\Requests\ApplicationRequest;

class MyApplicationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $applications = $user->applications()->with('specalization')->get();
        $specalizations = \App\Models\Specalization::where('is_visible', true)->get();
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
}
