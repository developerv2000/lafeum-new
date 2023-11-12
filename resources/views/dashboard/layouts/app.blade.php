<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Админка — {{ env('APP_NAME') }}</title>

    {{-- Noindex --}}
    <meta name="robots" content="none" />
    <meta name="googlebot" content="noindex, nofollow" />
    <meta name="yandex" content="none">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    {{-- Selectize --}}
    <link rel="stylesheet" href="{{ asset('plugins/selectize/selectize.css') }}">

    {{-- Simditor v2.3.28 --}}
    <link rel="stylesheet" href="{{ asset('plugins/simditor/simditor.css') }}">

    {{-- JQuery DateTimePicker --}}
    <link rel="stylesheet" href="{{ asset('plugins/date-time-picker/date-time-picker.min.css') }}">

    {{-- Normalize CSS --}}
    <link rel="stylesheet" href="{{ asset('plugins/normalize.css') }}">

    <link rel="stylesheet" href="{{ asset('css/dashboard/styles.css') }}">
</head>

<body class="body">
    @include('dashboard.layouts.header')
    @include('dashboard.layouts.aside')

    <main class="main">
        @include('dashboard.layouts.errors')
        @include('dashboard.layouts.spinner')
        @yield('main')
    </main>

    {{-- JQuery --}}
    <script src="{{ asset('plugins/jquery/jquery-3.6.4.min.js') }}"></script>

    {{-- Selectize --}}
    <script src="{{ asset('plugins/selectize/selectize.min.js') }}"></script>

    {{-- JQ Nested Set --}}
    <script src="{{ asset('plugins/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('plugins/jq-nested/jq-nested-sortable.js') }}"></script>

    {{-- JQuery DateTimePicker --}}
    {{-- https://www.jqueryscript.net/time-clock/Clean-jQuery-Date-Time-Picker-Plugin-datetimepicker.html --}}
    <script src="{{ asset('plugins/date-time-picker/date-time-picker.min.js') }}"></script>

    {{-- Simditor v2.3.28 --}}
    <script src="{{ asset('plugins/simditor/module.js') }}"></script>
    <script src="{{ asset('plugins/simditor/hotkeys.js') }}"></script>
    <script src="{{ asset('plugins/simditor/uploader.js') }}"></script>
    <script src="{{ asset('plugins/simditor/simditor.js') }}"></script>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>

</html>
