<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約内容の確認・変更</title>
</head>

<body>
    <h2>予約内容の確認・変更</h2>

    @if (session('status'))
        <div style="padding: 10px; background-color: #d4edda; color: #155724; border-radius: 4px; margin-bottom: 20px;">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div style="padding: 10px; background-color: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <p style="margin: 5px 0;"><strong>予約番号：</strong> #{{ $reservation->id }}</p>
        <p style="margin: 5px 0;"><strong>公演名：</strong> {{ $reservation->schedule->performance->title }}</p>
        <p style="margin: 5px 0;"><strong>日時：</strong>
            {{ \Carbon\Carbon::parse($reservation->schedule->start_at)->format('Y年m月d日 H:i') }}</p>
        <p style="margin: 5px 0;"><strong>ステータス：</strong>
            @if($reservation->status === 'cancelled')
                <span style="color: red; font-weight: bold;">キャンセル済み</span>
            @else
                <span style="color: green; font-weight: bold;">予約完了</span>
            @endif
        </p>
    </div>

    @if($reservation->status === 'reserved')
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

            <h3>お客様情報の変更</h3>
            <div style="margin-bottom: 10px;">
                <label>お名前（必須）：</label><br>
                <input type="text" name="customer_name" value="{{ old('customer_name', $reservation->customer_name) }}"
                    required style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label>メールアドレス（変更不可）：</label><br>
                <input type="email" value="{{ $reservation->customer_email }}" disabled
                    style="width: 100%; padding: 8px; background-color: #e9ecef;">
            </div>

            <div style="margin-bottom: 10px;">
                <label>電話番号：</label><br>
                <input type="text" name="customer_phone" value="{{ old('customer_phone', $reservation->customer_phone) }}"
                    style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>備考・メッセージ：</label><br>
                <textarea name="notes" rows="3"
                    style="width: 100%; padding: 8px;">{{ old('notes', $reservation->notes) }}</textarea>
            </div>

            <button type="submit"
                style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
                予約内容を更新する
            </button>
        </form>

        <hr style="margin: 30px 0;">

        <div style="background-color: #fff3cd; padding: 15px; border-radius: 5px;">
            <h4 style="margin-top: 0; color: #856404;">予約のキャンセル</h4>
            <p style="font-size: 0.9em; color: #856404;">予約をすべて取り消す場合は、以下のボタンを押してください。</p>
            <form action="{{ route('reservations.manage.cancel', $reservation->reservation_token) }}" method="POST"
                onsubmit="return confirm('本当に予約をキャンセルしますか？');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    style="background-color: #dc3545; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                    予約をキャンセルする
                </button>
            </form>
        </div>
    @endif
</body>

</html>