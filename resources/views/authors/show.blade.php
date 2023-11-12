@extends('layouts.app', ['pageClass' => 'authors-show'])

@section('leftbar')
    @include('leftbars.authors')
@endsection

@section('main')
    <section class="about authors-show__about">
        <div class="authors-show__about-divider">
            @if ($author->photo)
                <img class="authors-show__about-image" src="{{ asset('img/authors/' . $author->photo) }}" alt="{{ $author->name }}">
            @endif

            <div>
                <h1 class="main-title about__title">{{ $author->name }}</h1>
                <div class="about__desc">{!! $author->biography !!}</div>
            </div>
        </div>

        <x-search.get form-class="authors-show__search" />
    </section>

    <section class="quotes">
        <div class="quotes__list-container">
            <x-lists.quotes :quotes="$quotes" />
        </div>
    </section>
@endsection
