@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Все видео - ' . count($allItems) . ' элементов'
    ],

    'actions' => [
        'create',
        'multiselect',
        'multiple-destroy'
    ]
])

@section('main')
    @include('dashboard.searches.linked', ['titleColumn' => 'title'])

    <div class="table-container">
        @include('dashboard.tables.videos')
    </div>

    @include('dashboard.modals.single-destroy')
    @include('dashboard.modals.multiple-destroy')
@endsection
