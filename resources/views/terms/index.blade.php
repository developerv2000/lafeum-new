@extends('layouts.app', ['pageClass' => 'terms-index'])

@section('leftbar')
    @include('leftbars.checkboxed-categories', ['formID' => 'terms-index-search'])
@endsection

@section('main')
    <section class="about terms-index__about">
        <h1 class="main-title about__title">Термины</h1>
        <div class="about__desc">Немного текста про этот раздел. Что тут может посетитель просмотреть.</div>
        <x-search.get form-class="terms-index__search" form-id="terms-index-search" />
    </section>

    <section class="terms">
        <div class="terms__list-container">
            <x-lists.terms :terms="$terms" :subterms="$subterms" />
        </div>
    </section>
@endsection
