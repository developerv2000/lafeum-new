@props(['formClass', 'selector'])

<form class="search-form search-form--local {{ $formClass }}" data-submit="disabled">
    <input class="search-form__input" type="text" data-action="local-search" data-selector="{{ $selector }}" placeholder="Введите поисковой запрос">
    <span class="search-form__icon material-symbols-outlined">search</span>
</form>
