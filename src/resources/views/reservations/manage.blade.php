<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約内容の確認・変更</title>
</head>

<body style="margin: 0; padding: 0; height: 100%; overflow: hidden;">
    <div
        style="background-image: url('{{ asset('images/lr-background.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; min-height: 100vh; width: 100%; display: flex; justify-content: center; align-items: center; box-sizing: border-box;">
        <div
            style="width: 100%; height: 90vh; color: #2B0C0E; background-color:rgba(255, 255, 255, 0.8); margin-left: auto; margin-right: auto; padding: 20px; max-width: 600px; max-height: 90vh; overflow-y: auto; box-sizing: border-box;">
            @php
                $performance = $reservation->schedule->performance;
                $endAt = $performance->end_of_reservation_at;
                $isExpired = $endAt ? \Carbon\Carbon::now()->greaterThan($endAt) : false;
            @endphp

            <h2>予約内容の確認・変更</h2>

            @if (session('status'))
                <div style="padding: 10px; background-color: #c41a30; color: #fff; margin-bottom: 20px;">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div style="padding: 10px; background-color: #f8d7da; color: #721c24; margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="background-color: #f2f2f2; padding: 15px; margin-bottom: 20px;">
                <p style="margin: 5px 0;"><strong>予約番号：</strong> #{{ $reservation->id }}</p>
                <p style="margin: 5px 0;"><strong>公演名：</strong> {{ $reservation->schedule->performance->title }}</p>
                <p style="margin: 5px 0;"><strong>日時：</strong>
                    {{ \Carbon\Carbon::parse($reservation->schedule->start_at)->format('Y年m月d日 H:i') }}
                </p>
                <p style="margin: 5px 0;"><strong>ステータス：</strong>
                    @if($reservation->status === 'cancelled')
                        <span
                            style="color: #fff; background-color: #c41a30; font-weight: bold; padding: 5px; border-radius: 5px;">キャンセル済み</span>
                    @else
                        <span style="color: #c41a30; font-weight: bold;">予約完了</span>
                    @endif
                </p>
            </div>

            @if($reservation->status === 'reserved')

                @if($isExpired)
                    <div
                        style="padding: 15px; background-color: #fff5f5; color: #9c414c; border-radius: 5px; margin-bottom: 20px;">
                        <strong>【Web受付終了のお知らせ】</strong><br>
                        予約変更・キャンセルのWeb受付期間（{{ \Carbon\Carbon::parse($endAt)->format('Y年m月d日 H:i') }}まで）を過ぎているため、Webからの変更・取り消しはできません。<br>
                        内容の変更やキャンセルをご希望の場合は、お手数ですが直接劇団までご連絡ください。
                    </div>
                @else

                    <form action="{{ route('reservations.manage.update', $reservation->reservation_token) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h3>枚数の変更</h3>
                        @php
                            $ticketTypes = $reservation->schedule->performance->ticketTypes;
                            $maxLimit = $reservation->schedule->performance->max_tickets_per_person;
                            $currentDetails = $reservation->details->pluck('quantity', 'ticket_type_id')->toArray();
                        @endphp

                        @if($ticketTypes->count() > 0)
                            @foreach($ticketTypes as $type)
                                @php $qty = $currentDetails[$type->id] ?? 0; @endphp
                                <div style="margin-bottom: 10px;">
                                    <label>{{ $type->name }} ({{ number_format($type->price) }}円): </label>
                                    <select name="tickets[{{ $type->id }}]">
                                        @for($i = 0; $i <= $maxLimit; $i++)
                                            <option value="{{ $i }}" {{ old("tickets.{$type->id}", $qty) == $i ? 'selected' : '' }}>
                                                {{ $i }} 枚
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            @endforeach
                        @else
                            @php $qty = $reservation->details->first()->quantity ?? 1; @endphp
                            <div style="margin-bottom: 10px;">
                                <label>枚数: </label>
                                <select name="default_quantity">
                                    @for($i = 1; $i <= $maxLimit; $i++)
                                        <option value="{{ $i }}" {{ old('default_quantity', $qty) == $i ? 'selected' : '' }}>
                                            {{ $i }} 枚
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        @endif
                @endif

                    <h3>お客様情報の変更</h3>
                    <div style="margin-bottom: 10px;">
                        <label>お名前（必須）：</label><br>
                        <input type="text" name="customer_name"
                            value="{{ old('customer_name', $reservation->customer_name) }}" required
                            style="width: 100%; padding: 8px 0;">
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label>メールアドレス（変更不可）：</label><br>
                        <input type="email" value="{{ $reservation->customer_email }}" disabled
                            style="width: 100%; padding: 8px 0; background-color: #e9ecef;">
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label>電話番号：</label><br>
                        <input type="text" name="customer_phone"
                            value="{{ old('customer_phone', $reservation->customer_phone) }}"
                            style="width: 100%; padding: 8px 0;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>備考・メッセージ：</label><br>
                        <textarea name="notes" rows="3"
                            style="width: 100%; padding: 8px 0;">{{ old('notes', $reservation->notes) }}</textarea>
                    </div>

                    <button type="submit"
                        style="background-color: #2B0C0E; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
                        予約内容を更新する
                    </button>
                </form>

                <hr style="margin: 30px 0;">

                <div style="background-color: #fff5f5; padding: 15px; border-radius: 5px;">
                    <h4 style="margin-top: 0; color: #9c414c;">予約のキャンセル</h4>
                    <p style="font-size: 0.9em; color: #9c414c;">予約をすべて取り消す場合は、以下のボタンを押してください。</p>
                    <form action="{{ route('reservations.manage.cancel', $reservation->reservation_token) }}" method="POST"
                        onsubmit="return confirm('本当に予約をキャンセルしますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            style="background-color: #c41a30; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                            予約をキャンセルする
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</body>

</html>