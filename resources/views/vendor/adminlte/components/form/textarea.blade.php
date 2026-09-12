<div class="mb-3 {{ $fgroupClass }}">
    @isset($label)
        <label for="{{ $id }}" class="form-label{{ $attributes->has('required') ? ' required' : '' }}">
            {{ $label }}
            @if ($attributes->has('required'))
                <span class="required-indicator" aria-label="Campo obligatorio">*</span>
            @endif
        </label>
    @endisset

    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes->merge(['class' => 'form-control'.($hasError() ? ' is-invalid' : '')]) }}>{{ old($dotName(), $slot ?? '') }}</textarea>

    @if ($hasError())
        <div class="invalid-feedback d-block">{{ $errorMessage() }}</div>
    @endif
</div>
