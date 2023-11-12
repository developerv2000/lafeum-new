@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Фото',
        'Корзина - ' . count($allItems) . ' элементов',
    ],

    'actions' => [
        'multiselect',
        'multiple-destroy'
    ]
])

@section('main')
    <div class="table-container">
        @include('dashboard.tables.photos')
    </div>

    @include('dashboard.modals.single-destroy')
    @include('dashboard.modals.single-restore')
    @include('dashboard.modals.multiple-destroy')
@endsection
