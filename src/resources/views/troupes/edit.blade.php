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

            <input type="text" name="name" value="{{ old('name') }}" required placeholder="劇団名">
            <input type="text" name="representative_name" value="{{ old('representative_name') }}" required
                placeholder="代表者名">

            <select name="prefecture" id="prefecture"></select>

            <input type="text" name="description" placeholder="劇団説明文">
        </div>
    </div>
</body>

</html>