@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Все термины - ' . count($allItems) . ' элементов'
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
        @include('dashboard.tables.terms')
    </div>

    @include('dashboard.modals.single-destroy')
    @include('dashboard.modals.multiple-destroy')
@endsection
