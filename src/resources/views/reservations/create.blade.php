<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>{{ $performance->title }} - チケット予約</title>
</head>

<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1>{{ $performance->title }}</h1>
        <p>主催：{{ $performance->troupe->name }}</p>
        <!-- <p>会場：{{ $performance->venue_prefecture }}{{ $performance->venue_city }}</p> -->

        @if($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reservations.store', $performance->form_url_slug) }}" method="POST">
            @csrf

            <!-- 日時（ステージ）の選択 -->
            <h3>1. 日時選択</h3>
            <select name="performance_schedule_id" required>
                <option value="">-- 日時を選択してください --</option>
                @foreach($performance->schedules as $schedule)
                    <option value="{{ $schedule->id }}" {{ old('performance_schedule_id') == $schedule->id ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($schedule->start_at)->format('Y/m/d H:i') }}
                    </option>
                @endforeach
            </select>

            <!-- 券種と枚数選択（一人当たり上限数を動的に反映） -->
            <h3>2. チケット枚数 (最大{{ $performance->max_tickets_per_person }}枚まで)</h3>
            @forelse($performance->ticketTypes as $type)
                <div style="margin-bottom: 10px;">
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
                <div style="margin-bottom: 10px;">
                    <label>枚数: </label>
                    <select name="default_quantity">
                        @for($i = 1; $i <= $performance->max_tickets_per_person; $i++)
                            <option value="{{ $i }}" {{ old('default_quantity') == $i ? 'selected' : '' }}>
                                {{ $i }} 枚
                            </option>
                        @endfor
                    </select>
                </div>
            @endforelse


            <!-- 観客情報 -->
            <h3>3. お客様情報</h3>
            <p><label>お名前 * : <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                        required></label></p>
            <p><label>メールアドレス * : <input type="email" name="customer_email" value="{{ old('customer_email') }}"
                        required></label></p>
            <p><label>電話番号 : <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}"></label></p>
            <p><label>備考 : <textarea name="notes">{{ old('notes') }}</textarea></label></p>

            <button type="submit">予約を確定する</button>
        </form>
    </div>
</body>

</html>