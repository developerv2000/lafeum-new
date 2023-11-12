@extends('layouts.app', ['pageClass' => 'photos-show'])

@section('main')
    <div class="cards-show-wrapper">
        <x-return-home />
        <x-cards.photos :photo="$photo" />
    </div>
@endsection
