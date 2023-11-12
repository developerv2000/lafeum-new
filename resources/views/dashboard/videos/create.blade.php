@extends('dashboard.layouts.app', [
    'breadcrumbs' => ['Видео', 'Добавить'],

    'actions' => ['store'],
])

@section('main')
    <form class="form" id="create-form" action="{{ route($modelPrefixName . '.store') }}" method="POST">
        @csrf

        @include('dashboard.form.create-components.text-input', [
            'label' => 'Заголовок',
            'name' => 'title',
            'required' => true,
        ])

        @include('dashboard.form.create-components.text-input', [
            'label' => 'Ссылка',
            'name' => 'host_id',
            'required' => true,
        ])

        @include('dashboard.form.create-components.single-select', [
            'label' => 'Канал',
            'name' => 'channel_id',
            'required' => true,
            'options' => $channels,
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])

        @include('dashboard.form.create-components.multiple-select', [
            'label' => 'Категория',
            'name' => 'categories[]',
            'required' => true,
            'options' => $categories,
            'valueColumnName' => 'id',
            'titleColumnName' => 'name',
        ])

        @include('dashboard.form.create-components.date-time-input', [
            'label' => 'Дата публикации',
            'name' => 'publish_at',
            'required' => true,
        ])

    </form>
@endsection
