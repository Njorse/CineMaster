<button 
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
            inline-flex 
            items-center 
            justify-center
            text-xs
            px-5 
            py-2.5 
            bg-orange-600 
            hover:bg-orange-700 
            active:bg-orange-800 
            text-white 
            uppercase 
            tracking-widest 
            rounded-xl 
            shadow-md 
            shadow-orange-900/40 
            transition-all 
            duration-200 
            ease-in-out 
            focus:outline-none 
            focus:ring-2 
            focus:ring-orange-500 
            focus:ring-offset-2 
            focus:ring-offset-black 
            transform 
            hover:scale-[1.03] 
            active:scale-[0.97]
        '
    ]) }}>
    {{ $slot }}
</button>
