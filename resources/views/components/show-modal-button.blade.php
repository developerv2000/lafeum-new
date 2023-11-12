@props(['target', 'style', 'icon' => null, 'title' => null])

<button class="button button--{{ $style }} {{ $attributes['class'] }}" data-action="show-modal" data-modal-target="{{ $target }}" type="button" @if($title) title="{{ $title }}" @endif>
    <span class="button__icon material-symbols-outlined">{{ $icon }}</span>
    <span class="button__text">{{ $slot }}</span>
</button>
