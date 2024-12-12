<?php

use App\Models\User;
use App\Models\Product;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public $products = '';
    public $export = '/obat/export';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->products = Product::all();

        foreach ($this->products as $product) {
            if($product->transactions){
                $qty = $product->qty;
                foreach ($product->transactions as $trans) {
                    if ($trans->is_out == 1){
                        $qty -= $trans->qty;
                    } else {
                        $qty += $trans->qty;
                    }
                }
                $product->qty = $qty;
            }
        }
    }
}; ?>

<section>
    <header class="flex justify-between">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Products') }}

        </h2>

        <x-primary-button onclick="window.open('{{ $export }}', '_blank')">Export</x-primary-button>
    </header>

    <x-table>
        <x-slot name="head">
            <x-table.header>No</x-table.header>
            <x-table.header>Image</x-table.header>
            <x-table.header>Name</x-table.header>
            <x-table.header>Desc</x-table.header>
            <x-table.header>Qty</x-table.header>
            <x-table.header>Price</x-table.header>
            <x-table.header>Total Price</x-table.header>
            <x-table.header>Action</x-table.header>
        </x-slot>
        <x-slot name="body">
            @if (count($products) == 0)
            <x-table.row>
                <x-table.cell colspan="8" class="text-center">No Data</x-table.cell>
            </x-table.row>
            @endif
            @foreach ($products as $product)
            <x-table.row>
                <x-table.cell>{{ $product->id }}</x-table.cell>
                <x-table.cell> <img src="{{ asset($product->image) }}" width="128" alt=""> </x-table.cell>
                <x-table.cell>{{ $product->name }}</x-table.cell>
                <x-table.cell>{{ $product->desc }}</x-table.cell>
                <x-table.cell>{{ $product->qty }}</x-table.cell>
                <x-table.cell>{{ preg_replace('/\B(?=(\d{3})+(?!\d))/i', '.', $product->price) }}</x-table.cell>
                <x-table.cell>{{ preg_replace('/\B(?=(\d{3})+(?!\d))/i', '.', $product->qty * $product->price) }}</x-table.cell>
                <x-table.cell><x-secondary-link-button href="/obat/{{ $product->id }}">Edit</x-secondary-link-button> <x-danger-link-button onclick="if(confirm('Are you sure to delete?')) location.href='/obat/delete/{{ $product->id }}'; return false">Hapus</x-danger-link-button></x-table.cell>
            </x-table.row>
            @endforeach
        </x-slot>
    </x-table>
</section>
