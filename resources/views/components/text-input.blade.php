@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'w-full p-3 text-sm focus:outline-none',
        'style' => '
            border-radius: var(--radius-lg);
            border: 1px solid rgba(0,0,0,0.12);
            background: var(--surface);
            color: var(--text);
        '
    ]) }}
    onfocus="this.style.boxShadow='0 0 0 3px rgba(236,161,182,0.30)'; this.style.borderColor='var(--secondary)';"
    onblur="this.style.boxShadow='none'; this.style.borderColor='rgba(0,0,0,0.12)';"
/>