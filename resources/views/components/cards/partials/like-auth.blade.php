<div class="like">
    <span class="material-symbols-outlined like__icon {{ $item->likedBy($currentUser->id) ? 'like__icon--active' : '' }}" data-action="like" data-model="{{ $model }}" data-id="{{ $item->id }}">favorite</span>
    <p class="like__counter">{{ $item->likesCount() ?: '' }}</p>
</div>
