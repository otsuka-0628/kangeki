<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANGEKI</title>
    @vite([
        'resources/css/app.css'
    ])
</head>

<body>
    <!-- @if (session('success'))
        <div class="alert alert-success"
            style="color: green; background-color: #e6ffe6; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif -->
    <div class="dashboard-layout">
        @include('sidebar')

        <main class="main-contents">
            <h2>予約受付中の公演</h2>
        </main>
    </div>
</body>

</html>