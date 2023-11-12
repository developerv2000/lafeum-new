@props(['target', 'style', 'icon' => null])

<button class="button button--{{ $style }} {{ $attributes['class'] }}" data-action="hide-modal" type="button">
    <span class="button__icon material-symbols-outlined">{{ $icon }}</span>
    <span class="button__text">{{ $slot }}</span>
</button>
