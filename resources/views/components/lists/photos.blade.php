<div class="photos-list">
    @foreach ($photos as $photo)
        <img class="photos-list__item" src="{{ asset('img/photos/thumbs/' . $photo->filename) }}" alt="{{ $photo->filename }}" data-action="show-modal" data-modal-target="#photoModal{{ $photo->id }}">
    @endforeach

    @if($photos->hasPages())
        {{ $photos->links('layouts.pagination') }}
    @endif

    @foreach ($photos as $photo)
        @include('modals.photo')
    @endforeach
</div>
