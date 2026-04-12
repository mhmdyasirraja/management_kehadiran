<div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">

    <p class="text-gray-500 text-sm">
        {{ $title }}
    </p>

    <div class="flex items-center justify-between mt-2">

        <h2 class="text-2xl font-semibold {{ $color ?? 'text-gray-800' }}">
            {{ $value }}
        </h2>

        {{-- optional icon nanti --}}
        {{-- <span class="text-gray-300">📊</span> --}}

    </div>

</div>