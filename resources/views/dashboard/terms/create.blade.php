@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Термины', 'Добавить'],

    'actions' => ['store'],
])

@section('main')
    <form class="form" id="create-form" action="{{ route($modelPrefixName . '.store') }}" method="POST">
        @csrf

        @include('dashboard.form.create-components.text-input', [
            'label' => 'Название (Словарь)',
            'name' => 'name',
            'required' => false,
        ])

        @include('dashboard.form.create-components.wysiwyg-textarea', [
            'label' => 'Термин',
            'name' => 'body',
            'required' => true,
        ])

        @include('dashboard.form.create-components.boolean-radios', [
            'label' => 'Отображать в словаре ?',
            'name' => 'show_in_vocabulary',
        ])

        @include('dashboard.form.create-components.multiple-select', [
            'label' => 'Категория',
            'name' => 'categories[]',
            'required' => true,
            'options' => $categories,
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])

        @include('dashboard.form.create-components.multiple-select', [
            'label' => 'Область знаний',
            'name' => 'knowledges[]',
            'required' => true,
            'options' => $knowledges,
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])

        @include('dashboard.form.create-components.single-select', [
            'label' => 'Тип',
            'name' => 'type_id',
            'required' => true,
            'options' => $types,
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])

        @include('dashboard.form.create-components.date-time-input', [
            'label' => 'Дата публикации',
            'name' => 'publish_at',
            'required' => false,
        ])

    </form>
@endsection
