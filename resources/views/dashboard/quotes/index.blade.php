@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Все цитаты - ' . count($allItems) . ' элементов'
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
        @include('dashboard.tables.quotes')
    </div>

    @include('dashboard.modals.single-destroy')
    @include('dashboard.modals.multiple-destroy')
@endsection
