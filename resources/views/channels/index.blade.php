@extends('layouts.app', ['pageClass' => 'channels-index'])

@section('main')
    <section class="about channels-index__about">
        <h1 class="main-title about__title">Каналы</h1>
        <div class="about__desc">
            Полный список всех каналов по алфавиту, с возможностью их поиска.
        </div>

        <x-search.local form-class="channels-index__search" selector=".channels-list__item" />
    </section>

    <section class="channels-list-container">
        <div class="three-columned-block">
            <h3 class="three-columned-block__title">Список Каналов</h3>

            <div class="three-columned-list channels-list">
                @foreach ($channels as $channel)
                    <div class="channels-list__item">
                        <a class="channels-list__link" href="{{ route('channels.show', $channel->slug) }}">{{ $channel->name }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
