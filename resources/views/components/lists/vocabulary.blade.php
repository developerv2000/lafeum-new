<div class="three-columned-list vocabulary-list">
    @foreach ($terms as $term)
        <div class="vocabulary-list__item">
            <a class="vocabulary-list__link" href="{{ route('terms.show', $term->id) }}" data-id="{{ $term->id }}">{{ $term->name }}</a>
        </div>
    @endforeach
</div>

<div class="vocabulary-list-popup">
    <div class="vocabulary-list-popup__inner"></div>
</div>
