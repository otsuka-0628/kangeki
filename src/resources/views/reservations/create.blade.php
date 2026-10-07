<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>{{ $performance->title }} - チケット予約</title>
    @vite([
        'resources/css/app.css',
    ])
</head>

<body>
    <div class="reservation-bg" style="background-image: url('{{ asset('images/lr-background.jpg') }}')">

        <div class="reservation-create-container">

            <p class="sub-title">{{ $performance->sub_title }}</p>
            <h1>{{ $performance->title }}</h1>
            <p>主　　催：{{ $performance->troupe->name }}</p>
            <p>注意事項：{{ $performance->notes ?: '特になし' }}</p>

            @if($errors->any())
                <div style="color: #c41a30;">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="reservation-create-form">

                <form action="{{ route('reservations.store', $performance->form_url_slug) }}" method="POST">
                    @csrf

                    <!-- 日時（ステージ）の選択 -->
                    <h3>1. 日時選択</h3>
                    <div class="schedules-select">
                        <select name="performance_schedule_id" required>
                            <option value="">-- 日時を選択してください --</option>
                            @foreach($performance->schedules as $schedule)
                                @php

                                    $reservedCount = $schedule->reservations
                                        ->where('status', '!=', 'cancelled')
                                        ->flatMap->details
                                        ->sum('quantity');

                                    $remainingSeats = $schedule->capacity - $reservedCount;

                                    $isSoldOut = $remainingSeats <= 0;
                                @endphp

                                <option value="{{ $schedule->id }}" {{ $isSoldOut ? 'disabled' : '' }} {{ old('performance_schedule_id') == $schedule->id ? 'selected' : '' }}>

                                    {{ \Carbon\Carbon::parse($schedule->start_at)->format('Y/m/d H:i') }}

                                    @if($isSoldOut)
                                        【完売】
                                    @elseif($remainingSeats <= 5)
                                        （残りわずか：あと{{ $remainingSeats }}席）
                                    @else
                                        （残席あり）
                                    @endif

                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 券種と枚数選択（一人当たり上限数を動的に反映） -->
                    <h3>2. チケット枚数 (最大{{ $performance->max_tickets_per_person }}枚まで)</h3>
                    @forelse($performance->ticketTypes as $type)
                        <div class="tickets-count-form">
                            <label>{{ $type->name }} ({{ number_format($type->price) }}円): </label>
                            <select name="tickets[{{ $type->id }}]">
                                @for($i = 0; $i <= $performance->max_tickets_per_person; $i++)
                                    <option value="{{ $i }}" {{ old("tickets.{$type->id}") == $i ? 'selected' : '' }}>
                                        {{ $i }} 枚
                                    </option>
                                @endfor
                            </select>
                        </div>
                    @empty

                        <label>枚数: </label>
                        <select name="default_quantity">
                            @for($i = 1; $i <= $performance->max_tickets_per_person; $i++)
                                <option value="{{ $i }}" {{ old('default_quantity') == $i ? 'selected' : '' }}>
                                    {{ $i }} 枚
                                </option>
                            @endfor
                        </select>

                    @endforelse


                    <!-- 観客情報 -->
                    <h3>3. お客様情報</h3>

                    <div class="resrvation-form-group">
                        <label>お名前<span class="required-form">＊必須</span></label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required>
                    </div>

                    <div class="resrvation-form-group">
                        <label>メールアドレス<span class="required-form">＊必須</span></label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}" required>
                    </div>

                    <div class="resrvation-form-group">
                        <label>電話番号</label>
                        <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}">
                    </div>

                    <div class="resrvation-form-group">
                        <label>備考</label>
                        <textarea name="notes">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit">予約を確定する</button>


                </form>
            </div>
        </div>
    </div>
</body>

</html>