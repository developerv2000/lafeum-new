@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Термины',
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
        @include('dashboard.tables.terms')
    </div>

    @include('dashboard.modals.single-destroy')
    @include('dashboard.modals.single-restore')
    @include('dashboard.modals.multiple-destroy')
@endsection
