@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Все фото - ' . count($allItems) . ' элементов'
    ],

    'actions' => [
        'create',
        'multiselect',
        'multiple-destroy'
    ]
])

@section('main')
    @include('dashboard.searches.default')

    <div class="table-container">
        @include('dashboard.tables.photos')
    </div>

    @include('dashboard.modals.single-destroy')
    @include('dashboard.modals.multiple-destroy')
@endsection
