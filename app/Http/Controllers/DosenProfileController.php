<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DosenProfileController extends Controller
{
    /**
     * Show profile page
     */
    public function show()
    {
        $user = Auth::user();
        return view('dosen.profile.show', compact('user'));
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('dosen.profile.edit', compact('user'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'nuptk' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users')->ignore($user->id),
            ],
            'nomor_whatsapp' => 'nullable|string|max:15',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Validate current password if new password is provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak benar.'])->withInput();
            }
        }

        // Update profile data
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'nuptk' => $request->nuptk,
            'nomor_whatsapp' => $request->nomor_whatsapp,
        ];

        // Update password if provided
        if ($request->filled('new_password')) {
            $updateData['password'] = Hash::make($request->new_password);
        }

        $user->update($updateData);

        return redirect()->route('dosen.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
