@extends('layouts.app', ['pageClass' => 'knowledge-index'])

@section('main')
    <section class="about knowledge-index__about">
        <h1 class="main-title about__title">Области знаний</h1>
        <div class="about__desc">
            В этой рубрике термины и комментарии специалистов классифицированы более развернуто по группам и направлениям.
        </div>

        <x-search.local form-class="knowledge-index__search" selector=".knowledge-list__item" />
    </section>

    <section class="knowledge-blocks">
        <div class="knowledge-blocks__inner">
            @foreach ($knowledges as $item)
                <div class="three-columned-block">
                    <h3 class="three-columned-block__title">{{ $item->name }}</h3>

                    <div class="three-columned-list knowledge-list">
                        @foreach ($item->children as $child)
                            <div class="knowledge-list__item">
                                <a class="knowledge-list__link" href="{{ route('knowledge.show', $child->slug) }}">{{ $child->name }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
