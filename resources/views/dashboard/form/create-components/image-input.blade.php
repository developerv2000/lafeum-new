<div class="form__group">
    <label class="form__label @if($required) required @endif">{{ $label }}</label>

    <div class="local-image-container">
        <input class="form__input" type="file" name="{{ $name }}" accept=".png, .jpg, .jpeg" @required($required) data-action="display-local-image">
        <img class="form__image" src="{{ asset('img/dashboard/default-image.png') }}">
    </div>
</div>
