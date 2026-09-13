<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約一覧・管理</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @vite([
        'resources/css/app.css'
    ])
</head>

<body>
    <div class="dashboard-layout">
        @include('sidebar')


        <div class="main-contents">
            <h2>予約一覧・管理</h2>
            <p class="admin-notes">※二重予約などのトラブル防止のため回（日時）の変更はできません。お客様自身でキャンセルの上、希望公演日時での再予約をするようにお願いしてください。</p>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="admin-index-table">
                <thead>
                    <tr>
                        <th>予約日時</th>
                        <th>予約者名</th>
                        <th>email</th>
                        <th>回（日時）</th>
                        <th>予約内容</th>
                        <th>備考</th>
                        <th>ステータス</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr class="{{ $reservation->status === 'cancelled' ? 'table-secondary' : '' }}">
                            <td>{{ $reservation->created_at->format('Y/m/d H:i') }}</td>
                            <td>{{ $reservation->customer_name }}</td>
                            <td><small class="text-muted">{{ $reservation->customer_email }}</small></td>
                            <td>{{ $reservation->schedule->start_at->format('m/d H:i') }}</td>
                            <td>
                                @foreach($reservation->details as $detail)
                                    {{ $detail->ticketType->name ?? '一般' }} × {{ $detail->quantity }}枚<br>
                                @endforeach
                            </td>
                            <td>
                                @if(!empty($reservation->notes))
                                    {!! nl2br(e($reservation->notes)) !!}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
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

                                    <button type="button" class="btn-cancel" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $reservation->id }}">
                                        予約変更
                                    </button>

                                    <form action="{{ route('admin.reservations.cancel', $reservation->id) }}" method="POST"
                                        onsubmit="return confirm('本当にこの予約をキャンセルしますか？');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-cancel">予約取消</button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center">予約データがありません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $reservations->links() }}

            @foreach($reservations as $reservation)
                @if($reservation->status === 'reserved')
                    <div class="modal fade" id="editModal{{ $reservation->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel{{ $reservation->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $reservation->id }}">予約チケット枚数の変更</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <div class="mb-3 p-2 bg-light rounded">
                                            <strong>予約者：</strong> {{ $reservation->customer_name }} 様<br>
                                            <small class="text-muted">{{ $reservation->customer_email }}</small>
                                        </div>

                                        <hr>

                                        <h6>チケット内訳</h6>
                                        @foreach($reservation->details as $detail)
                                            <div class="row g-2 align-items-center mb-3">
                                                <div class="col-md-7">
                                                    <label class="form-label small text-muted mb-1">
                                                        チケット種類
                                                    </label>
                                                    <select name="details[{{ $detail->id }}][ticket_type_id]" class="form-select">
                                                        @foreach($reservation->schedule->performance->ticketTypes as $ticketType)
                                                            <option value="{{ $ticketType->id }}" {{ $detail->ticket_type_id == $ticketType->id ? 'selected' : '' }}>
                                                                {{ $ticketType->name }}（1枚
                                                                {{ number_format($ticketType->price ?? 0) }}円）
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-5">
                                                    <label class="form-label small text-muted mb-1">枚数</label>
                                                    <div class="input-group">
                                                        <input type="number" name="details[{{ $detail->id }}][quantity]"
                                                            class="form-control" value="{{ $detail->quantity }}" min="0" max="10"
                                                            required>
                                                        <span class="input-group-text">枚</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                        <button type="submit" class="btn btn-primary">枚数を更新する</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

</body>

</html>