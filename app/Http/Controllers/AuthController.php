<?php

namespace App\Http\Controllers;

use App\Helpers\LogLogin;
use App\Http\Requests\AuthRequests\AuthenticateRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            "title" => "Welcome Back"
        ]);
    }

    public function authenticate(AuthenticateRequest $request)
    {
        $remember = $request->boolean('remember');
        $credentials = $request->safe(['email', 'password']);

        if (Auth::attempt($credentials, $remember)) {
            request()->session()->regenerate();

            return redirect()
                ->route('dashboard.index');
            // ->with('success', 'Welcome! You have successfully logged in to the app. Enjoy your experience and make the most out of our features. If you have any questions or need assistance, feel free to reach out to our support team. Happy exploring!');
        }

        return redirect()
            ->route('auth.login')
            ->with('failed', 'The username or password you entered is incorrect. Please double-check your credentials and try again. If you continue to experience issues, please contact our support team for assistance.');
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->regenerate();
        request()->session()->regenerateToken();

        return redirect()
            ->route('auth.login')
            ->with('success', 'You have successfully logged out. Thank you for using our app! We hope to see you again soon.');
    }

    public function forgot()
    {
        return view('auth.forgot', [
            "title" => "Forgot Password"
        ]);
    }

    public function forgotPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function reset()
    {
        return view('auth.reset', [
            "title" => "Reset Password"
        ]);
    }

    public function resetPost(Request $request)
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

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('auth.login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
