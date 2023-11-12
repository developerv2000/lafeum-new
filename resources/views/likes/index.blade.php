@extends('layouts.app', ['pageClass' => 'likes-index'])

@section('leftbar')
    @include('leftbars.profile')
@endsection

@section('main')
    <section class="likes-index__about about">
        <h1 class="main-title about__title">То что мне понравилось</h1>
        <div class="about__desc">Немного текста про этот раздел. Что тут может посетитель просмотреть</div>
        <x-search.get form-class="likes-index__search" />
    </section>

    <section class="liked-items-section">
        <x-lists.mixed :items="$paginatedItems" :subterms="$subterms" />
    </section>
@endsection
