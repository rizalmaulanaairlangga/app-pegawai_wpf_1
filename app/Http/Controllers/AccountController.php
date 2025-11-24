<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; // Import User model for IDE recognition

class AccountController extends Controller
{
    public function edit()
    {
        return view('settings.index', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $rules = [
            'username' => [
                'required',
                'alpha_num',
                'min:3',
                'max:32',
                Rule::unique('users')->ignore($user->id),
            ],
        ];

        // Jika user ingin ubah password
        if ($request->filled('password')) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        }

        $validated = $request->validate($rules);

        // Update username dulu
        $updateData = [
            'username' => $validated['username'],
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // 👇 GUNAKAN UPDATE — tidak ada save()
        // Change to fill + save to avoid undefined method error
        $user->fill($updateData);
        $user->save();

        return redirect()
            ->route('settings.edit')
            ->with('success', 'Pengaturan akun berhasil diperbarui.');
    }
}
