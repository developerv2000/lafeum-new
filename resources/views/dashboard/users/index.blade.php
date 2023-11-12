@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Все пользователи - ' . count($allItems) . ' элементов'
    ],

    'actions' => [
        'multiselect',
        'multiple-destroy'
    ]
])

@section('main')
    <div class="table-container">
        @include('dashboard.tables.users')
    </div>

    @include('dashboard.modals.single-destroy')
    @include('dashboard.modals.multiple-destroy')
@endsection
