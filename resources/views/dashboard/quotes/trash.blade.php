@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Цитаты',
        'Корзина - ' . count($allItems) . ' элементов',
    ],

    'actions' => [
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
    @include('dashboard.modals.single-restore')
    @include('dashboard.modals.multiple-destroy')
@endsection
