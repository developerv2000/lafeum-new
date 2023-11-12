@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Область знаний', 'Редактировать', '#' . $item->id],

    'actions' => ['update'],
])

@section('main')
    <form class="form" id="edit-form" action="{{ route($modelPrefixName . '.update') }}" method="POST">
        @csrf
        @include('dashboard.form.edit-components.id-input')
        @include('dashboard.form.edit-components.previous-url-input')

        @include('dashboard.form.edit-components.text-input', [
            'label' => 'Название',
            'name' => 'name',
            'required' => true,
        ])

        @include('dashboard.form.edit-components.wysiwyg-textarea', [
            'label' => 'Описание',
            'name' => 'description',
            'required' => true,
        ])
    </form>
@endsection
