<div class="form__group">
    <label class="form__label @if($required) required @endif">{{ $label }}</label>

    <input class="form__input date-time-picker" type="text" name="{{ $name }}" value="{{ old($name, $item->{$name}) }}" @required($required)>
</div>
