@extends('layouts.app', ['pageClass' => 'knowledge-show'])

@section('leftbar')
    @include('leftbars.knowledge')
@endsection

@section('main')
    <section class="about knowledge-show__about">
        <h1 class="main-title about__title">{{ $knowledge->name }}</h1>
        <div class="about__desc">{!! $knowledge->description !!}</div>
        <x-search.get form-class="knowledge-show__search" />
    </section>

    <section class="terms">
        <div class="terms__list-container">
            <x-lists.terms :terms="$terms" :subterms="$subterms" />
        </div>
    </section>
@endsection
