<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 1. 入力チェック（メアドの形式か、パスワードが空じゃないか）
        $credentials = $request->validate([
            'userID' => 'required|email',
            'password' => 'required|string',
        ], [
            'userID.required' => 'メールアドレスを入力してください。',
            'userID.email' => 'メールアドレスの形式で入力してください。',
            'password.required' => 'パスワードを入力してください。',
        ]);

        $loginDate = [
            'email' => $credentials['userID'],
            'password' => $credentials['password'],
        ];

        if (Auth::attempt($loginDate)) {
            $request->session()->regenerate();
            return redirect('home')->with(
                'success',
                'ログインしました！'
            );
        }

        return back()->withErrors([
            'login_error' => 'メールアドレスまたはパスワードが間違っています。'
        ])->withInput($request->only('userID'));
    }
}
