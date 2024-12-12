<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg overflow-y-auto max-h-52">
                <livewire:transaction.table />
            </div>
            <div class="flex gap-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg w-full">
                    <livewire:transaction.create-transaction-in />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg w-full">
                    <livewire:transaction.create-transaction-out />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
