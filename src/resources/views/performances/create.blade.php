<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>公演情報登録</title>
    @vite([
        'resources/css/app.css'
    ])
</head>

<body>
    <div class="dashboard-layout">
        @include('sidebar')

        <div class="main-contents">
            <h2>新規公演の登録</h2>


            <form action="{{ route('performances.store') }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="error-text">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div class="create-container">

                    <!-- 冠タイトル -->
                    <div class="form-group">
                        <label class="form-label">冠タイトル</label>
                        <input type="text" name="sub_title" value="{{ old('sub_title') }}" placeholder="例：第〇回公演"
                            class="form-control">
                    </div>

                    <!-- 公演タイトル -->
                    <div class="form-group">
                        <label class="form-label">公演タイトル <span class="required-mark">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="例：夏の夜の夢"
                            class="form-control">
                    </div>

                    <!-- <hr class="form-divider"> -->

                    <!-- 1. 開演日時エリア -->
                    <div class="form-group">
                        <div class="group-header">
                            <label class="form-label">開演日時</label>
                            <button type="button" id="add-schedule-btn" class="btn-add">＋開演日時を追加</button>
                        </div>
                        <div id="schedule-container">
                            <div class="schedule-item dynamic-item" data-index="0">
                                <input type="datetime-local" class="schedule-input form-control"
                                    name="schedules[0][start_at]">
                            </div>
                        </div>
                    </div>

                    <!-- 2. 日時別座席数エリア -->
                    <div class="form-group">
                        <label class="form-label">日時別座席数</label>
                        <div id="seat-container">
                            <div class="seat-item dynamic-item" data-index="0">
                                <label class="seat-label sub-label">【開演日時 1】</label>
                                <input type="number" name="schedules[0][capacity]" placeholder="例：50"
                                    class="form-control">

                            </div>
                        </div>
                    </div>

                    <!-- チケット種類 -->
                    <div class="form-group">
                        <div class="group-header">
                            <label class="form-label">チケット種類</label>
                            <button type="button" id="add-ticket-btn">＋チケット種類を追加</button>
                        </div>
                        <div id="ticket-type-container">
                            <div class="ticket-type-item dynamic-item" data-index="0">
                                <input type="text" class="ticket-type-input form-control" name="tickets[0][name]"
                                    placeholder="例：一般、学生、前売り等">
                            </div>
                        </div>
                    </div>

                    <!-- チケット料金 -->
                    <div class="form-group">
                        <label class="form-label">チケット料金</label>
                        <div id="ticket-fee-container">
                            <div class="ticket-fee-item" data-index="0">
                                <label class="ticket-fee-label sub-label">【チケット種類 1】</label>
                                <div class="input-unit-wrapper">
                                    <input type="number" name="tickets[0][price]" placeholder="例：3000"
                                        class="form-control"><span class="unit">円</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 一人当たり予約上限枚数 -->
                    <div class="form-group">
                        <label class="form-label">一人当たり予約上限枚数</label>
                        <div class="input-unit-wrapper">
                            <input type="number" name="max_tickets_per_person"
                                value="{{ old('max_tickets_per_person', 5) }}" min="1" class="form-control"><span
                                class="unit">枚</span>
                        </div>
                    </div>

                    <!-- 予約受付期限 -->
                    <div class="form-group">
                        <label class="form-label">予約受付期限</label>
                        <input type="datetime-local" name="end_of_reservation_at"
                            value="{{ old('end_of_reservation_at') }}" class="form-control">
                    </div>

                    <!-- 注意事項 -->
                    <div class="form-group">
                        <label class="form-label">注意事項</label>
                        <textarea name="notes" rows="3" placeholder="開場時間や会場に関する注意事項など"
                            class="form-control">{{ old('notes') }}</textarea>
                    </div>

                    <div class="form-submit">
                        <input type="submit" value="登録" class="btn-submit">
                    </div>

                </div>
            </form>
        </div>

    </div>
</body>

</html>