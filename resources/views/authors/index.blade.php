@extends('layouts.app', ['pageClass' => 'authors-index'])

@section('main')
    <section class="about authors-index__about">
        <h1 class="main-title about__title">Авторы</h1>
        <div class="about__desc">
            Полный список всех авторов по алфавиту, с возможностью их поиска.
        </div>

        <x-search.local form-class="authors-index__search" selector=".authors-list__item" />
    </section>

    <section class="authors-list-container">
        <div class="three-columned-block">
            <h3 class="three-columned-block__title">Список Авторов</h3>

            <div class="three-columned-list authors-list">
                @foreach ($authors as $author)
                    <div class="authors-list__item">
                        <a class="authors-list__link" href="{{ route('authors.show', $author->slug) }}">{{ $author->name }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
