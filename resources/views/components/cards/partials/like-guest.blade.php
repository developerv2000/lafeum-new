<div class="like">
    <span class="material-symbols-outlined like__icon" data-action="show-modal" data-modal-target=".login-modal">favorite</span>
    <p class="like__counter">{{ $item->likesCount() ?: '' }}</p>
</div>
