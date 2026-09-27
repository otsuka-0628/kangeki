<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    //
    public function showRegisterForm()
    {
        return view('auth.user-register');
    }

    public function register(Request $request)
    {
        // 1. 入力チェック（バリデーション）
        // 画面の「name="userID"」と「name="password"」をチェックする
        $rules = [
            'userID' => 'required|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|string|min:8',
        ];
        $messages = [
            'userID.required' => 'メールアドレスを入力してください。',
            'userID.email' => 'メールアドレスの形式で入力してください。',
            'userID.unique' => 'すでに登録されているメールアドレスです。',
            'password.required' => 'パスワード入力されていません。',
            'password.min' => 'パスワードは８文字以上で入力して下さい。',
        ];

        $request->validate($rules, $messages);

        $trashedUser = User::withTrashed()
            ->where('email', $request->userID)
            ->whereNotNull('deleted_at')
            ->first();


        if ($trashedUser) {
            return redirect()->route('restore.confirm')->with([
                'email' => $request->userID,
                'password' => $request->password,
            ]);
        }


        $user = User::create([
            'email' => $request->userID,
            'password' => Hash::make($request->password),
            'role' => 'general',
        ]);


        event(new registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice')->with('success', '確認メールを送信しました！メール内のリンクから登録を完了させてください。');
    }
}