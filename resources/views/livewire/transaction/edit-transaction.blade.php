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
    public $is_out = '';
    public $qty = '';
    public $from_or_to = '';

    public $products = '';
    public $transaction = '';

    /**
     * Mount the component.
     */
    public function mount(string $id): void
    {
        $this->products = Product::all();
        $this->transaction = ProductTransaction::find($id);

        $this->product_id = $this->transaction->product_id;
        $this->is_out = $this->transaction->is_out;
        $this->qty = $this->transaction->qty;
        $this->from_or_to = $this->transaction->from_or_to;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function editTransaction(): void
    {
        $validated = $this->validate([
            'product_id' => ['required', 'integer'],
            'is_out' => ['required'],
            'qty' => ['required', 'integer'],
            'from_or_to' => ['required'],
        ]);

        $this->transaction->product_id = $validated['product_id'];
        $this->transaction->is_out = $validated['is_out'];
        $this->transaction->qty = $validated['qty'];
        $this->transaction->from_or_to = $validated['from_or_to'];

        $this->transaction->save();

        $this->redirect('/transaction');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Edit Product Detail') }}
        </h2>
    </header>

    <form wire:submit="editTransaction" class="mt-6 space-y-6">
        <div>
            <x-input-label for="product_id" :value="__('Product')" />
            <select wire:model.live="product_id" id="product_id" name="product_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                <option value="">Select Obat...</option>
                @foreach ($products as $product)
                <option value="{{$product->id}}" {{($product->id == $product_id) ? "selected=selected" : "" }}>{{$product->name}}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('product_id')" />
        </div>
        <div>
            <x-input-label for="is_out" :value="__('Transaction Type')" />
            <select wire:model.live="is_out" id="is_out" name="is_out" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                <option value="0" selected>Bought</option>
                <option value="1">Sold</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('is_out')" />
        </div>
        <div>
            <x-input-label for="qty" :value="__('Qty')" />
            <x-text-input wire:model.live="qty" id="qty" name="qty" type="number" class="mt-1 block w-full" required autocomplete="qty" />
            <x-input-error class="mt-2" :messages="$errors->get('qty')" />
        </div>
        <div>
            <x-input-label for="from_or_to" :value="__('From')" />
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
