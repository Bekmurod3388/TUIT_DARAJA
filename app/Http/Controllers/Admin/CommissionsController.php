<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commission;
use App\Http\Requests\CommissionRequest;

class CommissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'superadmin'])) {
                abort(403, 'Sizda admin panelga kirish huquqi yo‘q.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $commissions = Commission::all();
        return view('admin.commissions', compact('commissions'));
    }

    public function create()
    {
        $specalizations = \App\Models\Specalization::all();
        return view('admin.create-commission', compact('specalizations'));
    }

    public function store(CommissionRequest $request)
    {
        $data = $request->validated();
        Commission::create($data);
        return redirect()->route('admin.commissions')->with('success', 'Komissiya yaratildi!');
    }

    public function edit($id)
    {
        $commission = Commission::findOrFail($id);
        $specalizations = \App\Models\Specalization::all();
        return view('admin.edit-commission', compact('commission', 'specalizations'));
    }

    public function update(CommissionRequest $request, $id)
    {
        $commission = Commission::findOrFail($id);
        $data = $request->validated();
        $commission->update($data);
        return redirect()->route('admin.commissions')->with('success', 'Komissiya yangilandi!');
    }

    public function destroy($id)
    {
        $commission = Commission::findOrFail($id);
        $commission->delete();
        return redirect()->route('admin.commissions')->with('success', 'Komissiya o‘chirildi!');
    }
} 