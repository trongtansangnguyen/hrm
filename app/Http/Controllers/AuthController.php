<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    /**
     * Đăng xuất
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Đăng xuất thành công!');
    }

    /**
     * Hiển thị form quên mật khẩu
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Gửi link reset mật khẩu
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Gửi email với link reset password
        // Trong thực tế, bạn nên cấu hình mail và gửi email thật
        Mail::send('emails.reset-password', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', 'Link đặt lại mật khẩu đã được gửi đến email của bạn! Token: ' . $token);
    }

    /**
     * Hiển thị form reset mật khẩu
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Reset mật khẩu
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token không hợp lệ!']);
        }

        if (!Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['email' => 'Token không hợp lệ!']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Đặt lại mật khẩu thành công!');
    }

    /**
     * Hiển thị form thay đổi mật khẩu
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Thay đổi mật khẩu
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Thay đổi mật khẩu thành công!');
    }
}
