@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Категории - ' . count($allItems) . ' элементов'
    ],

    'actions' => [
        'create-for-model',
        'edit-nestedset-of-model'
    ]
])

@section('main')
    <div class="table-container">
        @include('dashboard.tables.categories')
    </div>
@endsection
