<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'userID' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ], [
            'userID.required' => 'ユーザーID（メールアドレス）を入力してください。',
            'userID.email' => '正しいメールアドレスの形式で入力してください。',
            'password.required' => '新しいパスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワード（確認用）と一致しません。',
            'token.required' => '無効なトークンです。',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->userID)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['userID' => '無効なトークンまたはメールアドレスです。']);
        }

        $user = User::where('email', $request->userID)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->userID)->delete();

        return redirect()->route('login')->with('status', 'パスワードの変更が完了しました。新しいパスワードでログインしてください。');
    }
}