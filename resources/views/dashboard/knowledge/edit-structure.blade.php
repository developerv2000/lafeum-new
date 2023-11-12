@extends('dashboard.layouts.app', [
    'breadcrumbs' => [
        'Область знаний',
        'Изменить структуру',
    ],

    'actions' => [
        'update-nestedset'
    ],

    'updateNestedsetUrl' => route('knowledge.update-nestedset')
])

@section('main')
    @include('dashboard.layouts.nested-set')
@endsection
