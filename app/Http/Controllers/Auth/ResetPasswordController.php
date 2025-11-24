<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        Log::info('=== START PASSWORD RESET PROCESS ===');
        
        // Debug 1: Cek data yang masuk
        Log::info('Reset Password Data:', $request->all());
        
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Debug 2: Cek apakah user exists
        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            Log::error('User not found for email: ' . $request->email);
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }
        Log::info('User found:', ['id' => $user->id, 'email' => $user->email]);

        // Debug 3: Cek token di database
        $tokenRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();
            
        if (!$tokenRecord) {
            Log::error('No token record found for email: ' . $request->email);
            return back()->withErrors(['email' => 'Token tidak ditemukan.']);
        }
        
        Log::info('Token record found:', [
            'email' => $tokenRecord->email,
            'token_from_db' => $tokenRecord->token,
            'token_from_request' => $request->token,
            'created_at' => $tokenRecord->created_at
        ]);

        // Debug 4: Cek token match - PERBAIKAN DI SINI!
        if (!Hash::check($request->token, $tokenRecord->token)) {
            Log::error('Token mismatch:', [
                'db_token' => $tokenRecord->token,
                'request_token' => $request->token,
                'hash_check' => Hash::check($request->token, $tokenRecord->token)
            ]);
            return back()->withErrors(['email' => 'Token tidak valid.']);
        }
        Log::info('Token matched successfully');

        // Debug 5: Proses reset dengan Password broker
        Log::info('Calling Password::reset...');
        
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                Log::info('Password reset callback executed for user:', ['email' => $user->email]);
                
                // Simpan password lama untuk comparison
                $oldPassword = $user->password;
                
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();

                Log::info('Password updated:', [
                    'old_password_hash' => substr($oldPassword, 0, 20) . '...',
                    'new_password_hash' => substr($user->password, 0, 20) . '...'
                ]);

                event(new PasswordReset($user));
                
                // Hapus token setelah berhasil reset
                $deleted = DB::table('password_resets')
                    ->where('email', $user->email)
                    ->delete();
                    
                Log::info('Token deleted:', ['deleted' => $deleted]);
            }
        );

        // Debug 6: Cek status return
        Log::info('Password reset status:', ['status' => $status]);

        Log::info('=== END PASSWORD RESET PROCESS ===');

        if ($status === Password::PASSWORD_RESET) {
            Log::info('Redirecting to login with success message');
            return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
        }

        Log::error('Password reset failed with status: ' . $status);
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}