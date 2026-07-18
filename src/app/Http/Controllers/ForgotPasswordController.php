<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'ユーザーID（メールアドレス）を入力してください。',
            'email.email' => '正しいメールアドレスの形式で入力してください。',
        ]);

        $status = Password::sendresetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'ご登録いただいたメールアドレスにメールを送信いたしました。メールに記載のURLからパスワードを再設定してください。メールが届かない場合は正しいメールアドレスを確認して再度ご入力ください。');
        }
        return back()->withErrors(['email' => '指定されたユーザーIDが見つかりません。']);
    }
}
