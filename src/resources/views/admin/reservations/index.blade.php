<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約一覧・管理</title>
    @vite([
        'resources/css/app.css'
    ])
</head>

<body>
    <div class="dashboard-layout">
        @include('sidebar')


        <div class="main-contents">
            <h2>予約一覧・管理</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="admin-index-table">
                <thead>
                    <tr>
                        <th>予約日時</th>
                        <th>予約者名</th>
                        <th>回（日時）</th>
                        <th>予約内容</th>
                        <th>ステータス</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr class="{{ $reservation->status === 'cancelled' ? 'table-secondary' : '' }}">
                            <td>{{ $reservation->created_at->format('Y/m/d H:i') }}</td>
                            <td>
                                {{ $reservation->customer_name }}<br>
                                <small class="text-muted">{{ $reservation->customer_email }}</small>
                            </td>
                            <td>{{ $reservation->schedule->start_at->format('m/d H:i') }}</td>
                            <td>
                                @foreach($reservation->details as $detail)
                                    {{ $detail->ticketType->name ?? '一般' }} × {{ $detail->quantity }}枚<br>
                                @endforeach
                            </td>
                            <td>
                                @if($reservation->status === 'reserved')
                                    <span class="badge bg-success">予約完了</span>
                                @elseif($reservation->status === 'cancelled')
                                    <span class="badge bg-danger">キャンセル済</span>
                                @endif
                            </td>
                            <td>
                                @if($reservation->status === 'reserved')
                                    <form action="{{ route('admin.reservations.cancel', $reservation->id) }}" method="POST"
                                        onsubmit="return confirm('本当にこの予約をキャンセルしますか？');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">予約取消</button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $reservations->links() }}
        </div>

</body>

</html>