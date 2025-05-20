<div>
    @if(session('success'))
        <div class="text-green-600">{{ session('success') }}</div>
    @endif

    <div class="flex space-x-2 justify-center">
        @foreach($otp as $index => $digit)
            <input
                type="text"
                maxlength="1"
                class="w-12 h-12 text-center border rounded"
                wire:model="otp.{{ $index }}"
                x-data
                x-ref="otp{{ $index }}"
                @keydown="$event.key === 'Backspace' && $refs.otp{{ max($index-1, 0) }}.focus()"
                @input="$refs.otp{{ min($index+1, 5) }}?.focus()"
                autocomplete="one-time-code"
            />
        @endforeach
    </div>

    @if($error)
        <div class="text-red-500 mt-2">{{ $error }}</div>
    @endif
</div>
