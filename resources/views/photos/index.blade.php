@extends('layouts.app', ['pageClass' => 'photos-index'])

@section('leftbar')
    @include('leftbars.checkboxed-categories', ['formID' => 'photos-index-search'])
@endsection

@section('main')
    <section class="about photos-index__about">
        <h1 class="main-title about__title">Фотографии</h1>
        <div class="about__desc">Немного текста про этот раздел. Что тут может посетитель просмотреть.</div>
        <x-search.get form-class="photos-index__search" form-id="photos-index-search" />
    </section>

    <section class="photos">
        <div class="photos__list-container">
            <x-lists.photos :photos="$photos" :photos="$photos" />
        </div>
    </section>
@endsection
