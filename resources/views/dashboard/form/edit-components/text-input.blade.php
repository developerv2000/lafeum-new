<div class="form__group">
    <label class="form__label @if($required) required @endif">{{ $label }}</label>

    <input class="form__input" type="text" name="{{ $name }}" @required($required) value="{{ old($name, $item->{$name}) }}">
</div>
