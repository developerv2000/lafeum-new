@extends('layouts.app', ['pageClass' => 'folders-show'])

@section('leftbar')
    @include('leftbars.profile')
@endsection

@section('main')
    <section class="favorites-show__about about">
        <h1 class="main-title about__title">{{ $folder->name }}</h1>
        <div class="about__desc">Немного текста про этот раздел. Что тут может посетитель просмотреть</div>
        <x-search.get form-class="favorites-show__search" />
    </section>

    <section class="folder-items-section">
        <x-lists.mixed :items="$paginatedItems" :subterms="$subterms" />
    </section>
@endsection
