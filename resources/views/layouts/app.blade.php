<!DOCTYPE html>
<html lang="ru">

<head>
    @include('layouts.meta-tags')

    {{-- Normalize CSS --}}
    <link rel="stylesheet" href="{{ asset('plugins/normalize.css') }}">

    {{-- App Styles --}}
    <link rel="stylesheet" href="{{ asset('css/app/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app/media.css') }}">
</head>

<body class="{{ $pageClass }}">
    @include('layouts.header')

    <div class="main-wrapper">
        @hasSection ('leftbar')
            @yield('leftbar')
        @endif

        <main class="main">
            @yield('main')
        </main>

        @include('layouts.rightbar')
        <x-spinner />

        @guest
            @include('modals.login')
            @include('modals.register')
            @include('modals.forgot-password')
        @endguest

        @include('modals.video')
        @include('layouts.svg-sprite')
    </div>

    @include('layouts.footer')

    {{-- Yandex Share Buttons --}}
    <script src="{{ asset('plugins/yandex-share.js') }}" defer></script>

    {{-- App Scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
