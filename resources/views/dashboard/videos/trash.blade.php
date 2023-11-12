@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Видео',
        'Корзина - ' . count($allItems) . ' элементов',
    ],

    'actions' => [
        'multiselect',
        'multiple-destroy'
    ]
])

@section('main')
    <div class="table-container">
        @include('dashboard.tables.videos')
    </div>

    @include('dashboard.modals.single-destroy')
    @include('dashboard.modals.single-restore')
    @include('dashboard.modals.multiple-destroy')
@endsection
