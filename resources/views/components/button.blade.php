@props(['style' => 'light', 'icon' => null, 'type' => null, 'title' => null])

<button class="button button--{{ $style }} {{ $attributes['class'] }}" @if($type) type="{{ $type }}" @endif @if($title) title="{{ $title }}" @endif>
    <span class="button__icon material-symbols-outlined">{{ $icon }}</span>
    <span class="button__text">{{ $slot }}</span>
</button>
