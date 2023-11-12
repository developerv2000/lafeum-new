<title>@hasSection('title')@yield('title'){{ ' — ЛАФЕЮМ' }}@else{{ 'ЛАФЕЮМ' }}@endif</title>

<link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

@production
    @include('layouts.seo-metrics')
@else
    <meta name="robots" content="none" />
    <meta name="googlebot" content="noindex, nofollow" />
    <meta name="yandex" content="none" />
@endproduction

<meta property="og:site_name" content="Лафеюм">
<meta property="og:type" content="object">
<meta name="twitter:card" content="summary_large_image">

@hasSection ('meta-tags')
    @yield('meta-tags')
@else
    <meta name="description"
        content="Информированность о методах развития личности и совершенствования профессиональных знаний, осведомленность в вопросах бытия и научно-популярных тем вместе взятых, без сомнения, способствуют повышению образованности и компетентности, расширению мировоззрения...">
    <meta property="og:title" content="Лафеюм">
    <meta property="og:description"
        content="Информированность о методах развития личности и совершенствования профессиональных знаний, осведомленность в вопросах бытия и научно-популярных тем вместе взятых, без сомнения, способствуют повышению образованности и компетентности, расширению мировоззрения...">
    <meta property="og:image" content="{{ asset('img/main/share-logo.png') }}">
    <meta property="og:image:alt" content="Лафеюм лого">
@endif
