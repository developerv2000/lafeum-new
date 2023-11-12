@extends('layouts.app', ['pageClass' => 'quotes-index'])

@section('leftbar')
    @include('leftbars.checkboxed-categories', ['formID' => 'quotes-index-search'])
@endsection

@section('main')
    <section class="about quotes-index__about">
        <h1 class="main-title about__title">Цитаты и афоризмы</h1>
        <div class="about__desc">Лучшие цитаты, афоризмы и высказывания великих ученых и мыслителей, и успешных людей на тематику сайта.</div>
        <x-search.get form-class="quotes-index__search" form-id="quotes-index-search" />
    </section>

    <section class="quotes">
        <div class="quotes__list-container">
            <x-lists.quotes :quotes="$quotes" />
        </div>
    </section>
@endsection
