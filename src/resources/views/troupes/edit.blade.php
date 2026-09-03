<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>劇団情報の登録</title>
    @vite([
        'resources/css/app.css'
    ])
</head>

<body>
    <div class="dashboard-layout">
        @include('sidebar')

        <div class="main-contents">
            <h2>劇団情報の登録</h2>

            @if ($errors->any())
                <div style="color: red; background-color: #fee; padding: 10px; margin-bottom: 10px; border: 1px solid red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('troupe.store') }}" method="POST">
                @csrf

                <input type="text" name="name" value="{{ old('name', $troupe->name) }}" required placeholder="劇団名">
                <input type="text" name="representative_name"
                    value="{{ old('representative_name', $troupe->representative_name) }}" required placeholder="代表者名">

                <select name="prefecture" id="prefecture">
                    <option value="">選択してください</option>

                    @foreach($prefectures as $pref)
                        <option value="{{ $pref }}" {{ old('prefecture', $troupe->prefecture) == $pref ? 'selected' : ''}}>
                            {{ $pref }}
                        </option>
                    @endforeach

                </select>

                <input type="text" name="description" value="{{ old('description', $troupe->description) }}"
                    placeholder="劇団説明文">

                <input type="submit" value="{{ $troupe->exists ? '更新' : '登録' }}" class="btn-submit">
            </form>

        </div>
    </div>
</body>

</html>