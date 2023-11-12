@extends('layouts.app', ['pageClass' => 'terms-show'])

@section('main')
    <div class="cards-show-wrapper">
        <x-return-home />
        <x-cards.terms :term="$term" />
    </div>
@endsection
