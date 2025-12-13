<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGLy</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gorditas:wght@400;700&family=Lora:ital,wght@0,400..700;1,400..700&family=Noto+Serif+JP:wght@200..900&display=swap" rel="stylesheet">
    @yield('css')
</head>

<body>
    <main>
        <div class="auth-form__content">
            <div class="auth-form__title">
                <h1 class="lora">PiGLy</h1>
            </div>
            @yield('content')
        </div>
    </main>
</body>

</html>