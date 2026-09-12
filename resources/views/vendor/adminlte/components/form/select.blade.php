<div class="mb-3 {{ $fgroupClass }}">
    @isset($label)
        <label for="{{ $id }}" class="form-label{{ $attributes->has('required') ? ' required' : '' }}">
            {{ $label }}
            @if ($attributes->has('required'))
                <span class="required-indicator" aria-label="Campo obligatorio">*</span>
            @endif
        </label>
    @endisset

    <select
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes->merge(['class' => 'form-select'.($hasError() ? ' is-invalid' : '')]) }}>
        {{ $slot }}
    </select>

    @if ($hasError())
        <div class="invalid-feedback d-block">{{ $errorMessage() }}</div>
    @endif
</div>
