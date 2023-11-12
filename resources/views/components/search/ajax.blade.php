@props(['formClass', 'formId' => ''])

<form class="search-form search-form--ajax {{ $formClass }}" id="{{ $formId }}">
    <input class="search-form__input" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Введите поисковой запрос">
    <span class="search-form__icon material-symbols-outlined">search</span>
</form>
