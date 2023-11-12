@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Категории',
        'Изменить структуру',
    ],

    'actions' => [
        'update-nestedset-of-model'
    ],

    'updateNestedsetUrl' => route('categories.update-nestedset')
])

@section('main')
    @include('dashboard.layouts.nested-set')
@endsection
