@extends('layouts.app', ['pageClass' => 'vocabulary-index'])

@section('main')
    <section class="about vocabulary-index__about">
        <h1 class="main-title about__title">Словарь по темам</h1>
        <div class="about__desc">
            На сегодня содержит более одной тысячи основных терминов, соответствующих тематике сайта. Для удобства термины дополнительно разбиты на темы. Большинство терминов взяты из Википедии с указанием ссылки на источник. В большинстве понятий имеются другие взаимосвязанные термины и ссылки. По мере обновления на основном источнике здесь они будут равным образом обновляться.
        </div>
        <x-search.ajax form-class="vocabulary-index__search" form-id="vocabulary-index-search" />
    </section>

    @include('vocabulary.filter')

    <section class="vocabulary-list-container">
        <x-lists.vocabulary :terms="$terms" />
    </section>
@endsection
