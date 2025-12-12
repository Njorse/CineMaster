@props(['value'])

<label 
    {{ $attributes->merge([
        'class' => '
            block 
            font-semibold 
            text-sm 
            text-orange-400 
            tracking-wide 
            mb-1 
            transition 
            duration-200 
            ease-in-out
        '
    ]) }}
>
    {{ $value ?? $slot }}
</label>
