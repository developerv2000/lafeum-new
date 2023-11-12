<div class="modal photo-modal" id="photoModal{{ $photo->id }}">
    <div class="modal__background"></div>
    <div class="modal__box">
        <x-cards.photos :photo="$photo" />
    </div>
</div>
