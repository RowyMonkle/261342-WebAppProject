@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm color:var(--text)']) }}>
    {{ $value ?? $slot }}
</label>
