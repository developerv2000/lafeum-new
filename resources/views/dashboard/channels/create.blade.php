@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Каналы', 'Добавить'],

    'actions' => ['store'],
])

@section('main')
    <form class="form" id="create-form" action="{{ route($modelPrefixName . '.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('dashboard.form.create-components.text-input', [
            'label' => 'Имя',
            'name' => 'name',
            'required' => true,
        ])

        @include('dashboard.form.create-components.wysiwyg-textarea', [
            'label' => 'Описание',
            'name' => 'description',
            'required' => false,
        ])
    </form>
@endsection
