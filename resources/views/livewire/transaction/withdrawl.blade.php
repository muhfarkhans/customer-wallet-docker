<div x-on:refresh-5.window="setTimeout(() => $dispatch('refresh-all'), 5000)">
    <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'form-withdrawl')"
        class="w-full bg-indigo-500">
        {{ __('Withdrawl') }}
    </x-primary-button>

    <x-modal name="form-withdrawl" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="store" class="p-6">

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Withdrawl form') }}
            </h2>

            <livewire:transaction.balance />

            <div class="mt-6">
                <x-input-label for="amount" value="{{ __('Number of amount?') }}" class="" />

                <x-text-input wire:model="amount" id="amount" name="amount" type="number"
                    class="block w-full mt-1" />

                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="bg-indigo-500 ms-3">
                    {{ __('withdrawl') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
