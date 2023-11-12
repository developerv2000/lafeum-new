@extends('layouts.app', ['pageClass' => 'channels-show'])

@section('leftbar')
    @include('leftbars.channels')
@endsection

@section('main')
    <section class="about channels-show__about">
        <h1 class="main-title about__title">{{ $channel->name }}</h1>
        <div class="about__desc">{!! $channel->description !!}</div>
        <x-search.get form-class="channels-show__search" />
    </section>

    <section class="videos">
        <div class="videos__list-container">
            <x-lists.videos :videos="$videos" />
        </div>
    </section>
@endsection
