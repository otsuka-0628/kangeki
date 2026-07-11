<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANGEKI</title>
    @vite([
        'resources/css/register-top.css'
    ])
</head>

<body>
    @if (session('success'))
        <div class="alert alert-success"
            style="color: green; background-color: #e6ffe6; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif
</body>

</html>