<div id="{{ $id }}"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl w-full max-w-md p-6 space-y-4">

        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold">{{ $title }}</h2>

            <button onclick="closeModal('{{ $id }}')"
                class="text-gray-400 hover:text-black">
                ✕
            </button>
        </div>

        {{ $slot }}

    </div>
</div>