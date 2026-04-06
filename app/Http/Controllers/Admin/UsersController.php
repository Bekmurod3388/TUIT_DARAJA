<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserUpdateRequest;

class UsersController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $this->authorize('viewAny', User::class);
        $users = User::all();
        return view('admin.users', compact('user', 'users'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $editUser = User::findOrFail($id);
        $this->authorize('update', $editUser);
        return view('admin.edit-user', compact('user', 'editUser'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $editUser = User::findOrFail($id);
        $this->authorize('update', $editUser);
        $editUser->update($request->validated());
        return redirect()->route('admin.users')->with('success', 'Foydalanuvchi yangilandi!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Foydalanuvchi o\'chirildi!');
    }
}
