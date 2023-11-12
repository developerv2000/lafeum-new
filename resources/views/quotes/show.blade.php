@extends('layouts.app', ['pageClass' => 'quotes-show'])

@section('main')
    <div class="cards-show-wrapper">
        <x-return-home />
        <x-cards.quotes :quote="$quote" />
    </div>
@endsection
