@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Каналы', 'Редактировать', '#' . $item->id],

    'actions' => ['update', 'destroy'],
])

@section('main')
    <form class="form" id="edit-form" action="{{ route($modelPrefixName . '.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('dashboard.form.edit-components.id-input')
        @include('dashboard.form.edit-components.previous-url-input')

        @include('dashboard.form.edit-components.text-input', [
            'label' => 'Имя',
            'name' => 'name',
            'required' => true,
        ])

        @include('dashboard.form.edit-components.wysiwyg-textarea', [
            'label' => 'Описание',
            'name' => 'description',
            'required' => false,
        ])
    </form>

    @include('dashboard.modals.single-destroy', ['itemID' => $item->id])
@endsection
