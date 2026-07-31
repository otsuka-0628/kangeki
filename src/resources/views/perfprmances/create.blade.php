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

            <!-- エラー表示 -->
            @if($errors->any())
                <div class="error-text">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('performances.store') }}" method="POST">
                @csrf

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

                    <hr class="form-divider">

                    <!-- 1. 開演日時エリア -->
                    <div class="form-group">
                        <div class="group-header">
                            <label class="form-label">① 開演日時</label>
                            <button type="button" id="add-schedule-btn" class="btn-add">＋開演日時を追加</button>
                        </div>
                        <div id="schedule-container">
                            <div class="schedule-item dynamic-item" data-index="0">
                                <input type="text" class="schedule-input form-control" name="schedules[0][start_time]"
                                    placeholder="例：8/1(土) 18:00開演">
                            </div>
                        </div>
                    </div>

                    <!-- 2. 日時別座席数エリア -->
                    <div class="form-group">
                        <label class="form-label">② 日時別座席数</label>
                        <div id="seat-container">
                            <div class="seat-item dynamic-item" data-index="0">
                                <label class="seat-label sub-label">【開演日時 1】の座席数：</label>
                                <input type="number" name="schedules[0][capacity]" placeholder="例：50"
                                    class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- 以下、同じような形でクラス化して作っていけばOK！ -->

                </div>
            </form>
        </div>

    </div>
</body>

</html>