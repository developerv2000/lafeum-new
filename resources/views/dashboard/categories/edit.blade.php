@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Категории', 'Редактировать', '#' . $item->id],

    'actions' => ['update'],
])

@section('main')
    <form class="form" id="edit-form" action="{{ route($modelPrefixName . '.update') }}" method="POST">
        @csrf
        @include('dashboard.form.edit-components.id-input')
        @include('dashboard.form.edit-components.previous-url-input')

        <input type="hidden" name="model" value="{{ request()->model }}">

        @include('dashboard.form.edit-components.text-input', [
            'label' => 'Название',
            'name' => 'name',
            'required' => true,
        ])
    </form>
@endsection
