<div class="checkbox">
    <label for="item{{ $item->id }}">
        <input type="checkbox" name="id[]" id="item{{ $item->id }}" value="{{ $item->id }}" form="multiple-destroy-form">
        <span></span>
    </label>
</div>
