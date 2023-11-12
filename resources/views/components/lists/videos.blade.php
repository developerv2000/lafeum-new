<div class="videos-list cards-list">
    @foreach ($videos as $video)
        <x-cards.videos :video="$video" />
    @endforeach

    @if($videos->hasPages())
        {{ $videos->links('layouts.pagination') }}
    @endif
</div>
