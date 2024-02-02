<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="grid grid-cols-1 gap-2 mx-auto md:grid-cols-4 max-w-7xl sm:px-6 lg:px-8">
            <div>
                <livewire:profile />
            </div>
            <div class="col-span-3">
                <livewire:dashboard.transaction-table />
            </div>
        </div>
    </div>
</x-app-layout>
