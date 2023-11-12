<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="robots" content="none" />
    <meta name="googlebot" content="noindex, nofollow" />
    <meta name="yandex" content="none" />

    <title>ЛАФЕЮМ</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('plugins/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/styles.css') }}">
</head>

<body>
    <main class="main">
        <div class="main__inner">
            @yield('main')
        </div>

        <x-spinner />
    </main>

    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
