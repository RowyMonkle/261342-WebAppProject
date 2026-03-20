<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold transition'
]) }}
style="
    background: var(--primary);
    color: #ffffff;
    border-radius: var(--radius-xl);
"
onmouseover="this.style.background='var(--secondary)'"
onmouseout="this.style.background='var(--primary)'"
>
    {{ $slot }}
</button>