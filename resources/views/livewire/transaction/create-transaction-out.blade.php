<?php

use App\Models\User;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public $product_id = '';
    public $qty = '';
    public $is_out = '';
    public $from_or_to = '';

    public $products = '';
    public $transactions = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->products = Product::all();
        $this->transactions = ProductTransaction::all();
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function productOut(): void
    {
        $validated = $this->validate([
            'product_id' => ['required', 'integer'],
            'qty' => ['required', 'integer'],
            'from_or_to' => ['required'],
        ]);

        $transaction = ProductTransaction::create($validated);
        $transaction->fill(['is_out' => 1]);
        $transaction->save();

        $this->redirect('/transaction');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Sell Product') }}
        </h2>
    </header>

    <form wire:submit="productOut" class="mt-6 space-y-6">
        <div>
            <x-input-label for="product_id" :value="__('Product')" />
            <select wire:model.live="product_id" id="product_id" name="product_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                <option value="" selected>Select Obat...</option>
                @foreach ($products as $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('product_id')" />
        </div>
        <div>
            <x-input-label for="qty" :value="__('Qty')" />
            <x-text-input wire:model.live="qty" id="qty" name="qty" type="number" class="mt-1 block w-full" required autocomplete="qty" />
            <x-input-error class="mt-2" :messages="$errors->get('qty')" />
        </div>
        <div>
            <x-input-label for="from_or_to" :value="__('To')" />
            <x-text-input wire:model.live="from_or_to"  id="from_or_to" name="from_or_to" type="text" class="mt-1 block w-full" required autocomplete="from" />
            <x-input-error class="mt-2" :messages="$errors->get('from_or_to')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
