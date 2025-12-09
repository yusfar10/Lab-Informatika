<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;

class PasswordResetController extends Controller
{
    // Menampilkan form lupa password
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Mengirim link reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Menampilkan form reset password
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Reset password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            // Find the user and log them in
            $user = User::where('email', $request->email)->first();
            if ($user) {
                Auth::login($user);
                // Redirect based on role
                switch ($user->role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard')->with('status', 'Password berhasil direset dan Anda telah login.');
                    case 'mahasiswa':
                        return redirect()->route('mahasiswa.dashboard')->with('status', 'Password berhasil direset dan Anda telah login.');
                    case 'dosen':
                        return redirect()->route('guest.dashboard')->with('status', 'Password berhasil direset dan Anda telah login.');
                    default:
                        return redirect()->route('guest.dashboard')->with('status', 'Password berhasil direset dan Anda telah login.');
                }
            }
        }

        return back()->withErrors(['email' => [__($status)]]);
    }
}
