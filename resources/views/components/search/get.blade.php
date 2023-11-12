@props(['formClass', 'formId' => ''])

<form class="search-form search-form--get {{ $formClass }}" id="{{ $formId }}" action="{{ url()->current() }}" method="GET" data-on-submit="show-spinner">
    <input class="search-form__input" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Введите поисковой запрос">
    <span class="search-form__icon material-symbols-outlined">search</span>
</form>
