@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Каналы',
        'Корзина - ' . count($allItems) . ' элементов',
    ],

    'actions' => [
        'multiselect',
        'multiple-destroy'
    ]
])

@section('main')
    <div class="table-container">
        @include('dashboard.tables.channels')
    </div>

    @include('dashboard.modals.single-destroy')
    @include('dashboard.modals.single-restore')
    @include('dashboard.modals.multiple-destroy')
@endsection
