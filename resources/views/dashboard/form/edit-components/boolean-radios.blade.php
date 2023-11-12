<div class="form__group">
    <label class="form__label">{{ $label }}</label>

    <div class="form__radio-group">
        <label><input type="radio" name="{{ $name }}" value="0" @checked($item->{$name} == 0)> Нет</label>
        <label><input type="radio" name="{{ $name }}" value="1" @checked($item->{$name} == 1)> Да</label>
    </div>
</div>
