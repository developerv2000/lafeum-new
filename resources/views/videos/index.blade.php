@extends('layouts.app', ['pageClass' => 'videos-index'])

@section('leftbar')
    @include('leftbars.checkboxed-categories', ['formID' => 'videos-index-search'])
@endsection

@section('main')
    <section class="about videos-index__about">
        <h1 class="main-title about__title">Видео</h1>
        <div class="about__desc">Немного текста про этот раздел. Что тут может посетитель просмотреть</div>
        <x-search.get form-class="videos-index__search" form-id="videos-index-search" />
    </section>

    <section class="videos">
        <div class="videos__list-container">
            <x-lists.videos :videos="$videos" />
        </div>
    </section>
@endsection
