<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary px-4 py-2']) }}>
    {{ $slot }}
</button>