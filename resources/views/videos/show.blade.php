@extends('layouts.app', ['pageClass' => 'videos-show'])

@section('main')
    <div class="cards-show-wrapper">
        <x-return-home />
        <x-cards.videos :video="$video" />
    </div>
@endsection
