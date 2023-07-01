<x-layout.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Query Suggestion') }} / {{ __('History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl m-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg h-100">
            <livewire:history-suggestion />
        </div>
    </div>
</x-layout.app>