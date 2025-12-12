@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge([
        'class' => '
            text-sm 
            text-orange-500 
            font-medium 
            space-y-1 
            mt-1 
            bg-black/20 
            border-l-4 
            border-orange-500 
            pl-2 
            rounded-sm 
            animate-pulse-slow
        '
    ]) }}>
        @foreach ((array) $messages as $message)
            <li>⚠️ {{ $message }}</li>
        @endforeach
    </ul>
@endif
