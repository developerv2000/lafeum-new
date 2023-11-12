@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Область знаний - ' . count($allItems) . ' элементов'
    ],

    'actions' => [
        'create',
        'edit-nestedset'
    ]
])

@section('main')
    @include('dashboard.searches.linked', ['titleColumn' => 'name'])

    <div class="table-container">
        @include('dashboard.tables.knowledge')
    </div>
@endsection
