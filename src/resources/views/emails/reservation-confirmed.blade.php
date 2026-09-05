<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2>{{ $reservation->customer_name }} 様</h2>
    <p>この度はご予約いただき、誠にありがとうございます。</p>
    <p>以下の内容でご予約を承りました。</p>

    <div
        style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #e9ecef;">
        <p style="margin: 5px 0; font-size: 1.1em; color: #2b6cb0;"><strong>予約番号： #{{ $reservation->id }}</strong></p>
        <hr style="border: none; border-top: 1px solid #ddd; margin: 10px 0;">
        <p style="margin: 5px 0;"><strong>公演名：</strong> {{ $reservation->schedule->performance->title }}</p>
        <p style="margin: 5px 0;"><strong>主催：</strong> {{ $reservation->schedule->performance->troupe->name }}</p>
        <p style="margin: 5px 0;"><strong>日時：</strong>
            {{ \Carbon\Carbon::parse($reservation->schedule->start_at)->format('Y年m月d日 H:i') }}</p>
        <p style="margin: 5px 0;"><strong>お名前：</strong> {{ $reservation->customer_name }} 様</p>

        <p style="margin: 10px 0 5px 0;"><strong>予約枚数：</strong></p>
        <ul>
            @foreach($reservation->details as $detail)
                <li>
                    @if($detail->ticketType)
                        {{ $detail->ticketType->name }}（{{ number_format($detail->ticketType->price) }}円）:
                        {{ $detail->quantity }} 枚
                    @else
                        {{ $detail->quantity }} 枚
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <div
        style="background-color: #fffaf0; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #fbd38d;">
        <p style="margin: 0 0 10px 0; font-weight: bold; color: #c05621;">【予約内容の確認・変更・キャンセルについて】</p>
        <p style="margin: 0 0 10px 0; font-size: 0.95em;">予約枚数の変更やキャンセルは、以下の専用URLから行っていただけます。</p>
        <p style="margin: 0; word-break: break-all;">
            <a href="{{ url('/reservations/manage/' . $reservation->reservation_token) }}" style="color: #3182ce;">
                {{ url('/reservations/manage/' . $reservation->reservation_token) }}
            </a>
        </p>
    </div>

    <hr style="margin: 30px 0; border: none; border-top: 1px solid #ccc;">
    <p style="font-size: 0.85em; color: #777;">※メールを紛失された場合や操作がうまくいかない場合は、劇団まで直接お問い合わせください。</p>
    <p style="font-size: 0.85em; color: #777;">※このメールは送信専用アドレスから自動送信されています。</p>
</body>

</html>