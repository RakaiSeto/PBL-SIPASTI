<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'fullname' => 'required|string|max:255',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user->fullname = $request->fullname;

    if ($request->hasFile('profile_picture')) {
        if ($user->profile_picture && $user->profile_picture !== 'default.png') {
            Storage::delete('public/profile/' . $user->profile_picture);
        }

        $filename = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
        $request->file('profile_picture')->storeAs('public/profile', $filename);
        $user->profile_picture = $filename;
    }

    $user->save();

    return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
}

public function changePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->old_password, $user->password)) {
        return redirect()->back()->with('error', 'Password lama tidak sesuai.');
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    // Redirect sesuai role
    $role = $user->role->role_nama;

    switch ($role) {
        case 'Admin':
            return redirect('/admin')->with('success', 'Password berhasil diperbarui.');
        case 'Sarpras':
            return redirect('/sarpras')->with('success', 'Password berhasil diperbarui.');
        case 'Teknisi':
            return redirect('/teknisi')->with('success', 'Password berhasil diperbarui.');
        case 'Civitas':
            return redirect('/civitas')->with('success', 'Password berhasil diperbarui.');
        default:
            return redirect('/')->with('success', 'Password berhasil diperbarui.');
    }
}

}
