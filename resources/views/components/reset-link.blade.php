@props(['class', 'text' => 'Сброс фильтра', 'href' => url()->current()])

<a class="reset-link {{ $class }}" href="{{ $href }}">{{ $text }}</a>
