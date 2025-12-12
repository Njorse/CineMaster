@props(['disabled' => false])

<input 
    @disabled($disabled) 
    {{ $attributes->merge([
        'class' => '
            bg-gray-900 
            border border-orange-500/50 
            text-white 
            placeholder-gray-400 
            rounded-lg 
            shadow-md 
            focus:outline-none 
            focus:ring-2 
            focus:ring-orange-500 
            focus:border-orange-500 
            transition 
            duration-200 
            ease-in-out
        '
    ]) }}
>
