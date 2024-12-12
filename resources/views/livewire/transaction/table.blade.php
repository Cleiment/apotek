<?php

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\User;
use App\Models\ProductTransaction;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public $transactions = '';
    public $export = '/transaction/export';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->transactions = ProductTransaction::all();
    }

    public function downloadPDF(): void {
        redirect('/transaction/export');
    }
}; ?>

<section>
    <header class="flex justify-between">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Transactions') }}
        </h2>

        <x-primary-button onclick="window.open('{{ $export }}', '_blank')">Export</x-primary-button>
    </header>

    <x-table>
        <x-slot name="head">
            <x-table.header>No</x-table.header>
            <x-table.header>Image</x-table.header>
            <x-table.header>Product</x-table.header>
            <x-table.header>Desc</x-table.header>
            <x-table.header>Type</x-table.header>
            <x-table.header>From / To</x-table.header>
            <x-table.header>Qty</x-table.header>
            <x-table.header>Price</x-table.header>
            <x-table.header>Total Price</x-table.header>
            <x-table.header>Action</x-table.header>
        </x-slot>
        <x-slot name="body">
            @if (count($transactions) == 0)
            <x-table.row>
                <x-table.cell colspan="12" class="text-center">No Data</x-table.cell>
            </x-table.row>
            @endif
            @foreach ($transactions as $transaction)
            <x-table.row>
                <x-table.cell>{{ $transaction->id }}</x-table.cell>
                <x-table.cell> <img src="{{ asset($transaction->product->image) }}" width="128" alt=""> </x-table.cell>
                <x-table.cell>{{ $transaction->product->name }}</x-table.cell>
                <x-table.cell>{{ $transaction->product->desc }}</x-table.cell>
                <x-table.cell>{{ $transaction->is_out == '0' ? "Bought" : "Sold" }}</x-table.cell>
                <x-table.cell>{{ $transaction->from_or_to }}</x-table.cell>
                <x-table.cell>{{ $transaction->qty }}</x-table.cell>
                <x-table.cell>{{  preg_replace('/\B(?=(\d{3})+(?!\d))/i', '.', $transaction->product->price) }}</x-table.cell>
                <x-table.cell >{{ ($transaction->is_out == '0' ? "-" : "").preg_replace('/\B(?=(\d{3})+(?!\d))/i', '.', $transaction->qty * $transaction->product->price) }}</x-table.cell>
                <x-table.cell><x-secondary-link-button href="/transaction/{{ $transaction->id }}">Edit</x-secondary-link-button> <x-danger-link-button onclick="if(confirm('Are you sure to delete?')) location.href = '/transaction/delete/{{ $transaction->id }}'; return false">Delete</x-danger-link-button></x-table.cell>
            </x-table.row>
            @endforeach
        </x-slot>
    </x-table>
</section>
