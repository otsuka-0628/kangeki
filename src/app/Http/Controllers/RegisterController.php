<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            // 必須、メアド形式、usersテーブルのemailカラムと重複不可
            'userID' => 'required|email|max:255|unique:users,email',
            // 必須、最低8文字以上
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

        // 2. データベースに保存する
        // 設計した users テーブルのカラム名に合わせてデータを入れる
        $user = User::create([
            // 画面から届いた「userID」を、DBの「email」に入れる
            'email' => $request->userID,
            // パスワードは必ずハッシュ化（暗号化）して保存
            'password' => Hash::make($request->password),
            // 初期値として「一般劇団」を設定（設計通りやね！）
            'role' => 'general',
        ]);

        Auth::login($user);

        // 3. 登録が終わったら、とりあえずトップページ（/）にリダイレクトする
        return redirect('/home')->with('success', 'ユーザー登録が完了しました！');
    }
}