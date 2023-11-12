@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Область знаний', 'Добавить'],

    'actions' => ['store'],
])

@section('main')
    <form class="form" id="create-form" action="{{ route($modelPrefixName . '.store') }}" method="POST">
        @csrf

        @include('dashboard.form.create-components.text-input', [
            'label' => 'Название',
            'name' => 'name',
            'required' => true,
        ])

        @include('dashboard.form.create-components.wysiwyg-textarea', [
            'label' => 'Описание',
            'name' => 'description',
            'required' => true,
        ])

        @include('dashboard.form.create-components.single-select', [
            'label' => 'Родитель',
            'name' => 'parent_id',
            'required' => false,
            'options' => $roots,
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])
    </form>
@endsection
