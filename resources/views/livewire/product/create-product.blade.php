<?php

use App\Models\User;
use App\Models\Product;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public $name = '';
    public $desc = '';
    public $qty = '';
    public $price = '';
    public $image = '';

    public $products = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->products = Product::all();
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function createProduct(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', "max:100"],
            'desc' => ['required', 'string'],
            'qty' => ['required', 'integer'],
            'price' => ['required', 'integer']
        ]);

        $path = $this->image->store('products-image');
        $validated['image'] = $path;
        $product = Product::create($validated);

        $this->redirect('/obat');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Create Products') }}
        </h2>
    </header>

    <form wire:submit="createProduct" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model.live="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="desc" :value="__('Desc')" />
            <x-text-area wire:model.live="desc" id="desc" name="desc" class="mt-1 block w-full" required autocomplete="desc" />
            <x-input-error class="mt-2" :messages="$errors->get('desc')" />
        </div>
        <div>
            <x-input-label for="qty" :value="__('Qty')" />
            <x-text-input wire:model.live="qty" id="qty" name="qty" type="number" class="mt-1 block w-full" required autocomplete="qty" />
            <x-input-error class="mt-2" :messages="$errors->get('qty')" />
        </div>
        <div>
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input wire:model.live="price"  id="price" name="price" type="number" class="mt-1 block w-full" required autocomplete="price" />
            <x-input-error class="mt-2" :messages="$errors->get('price')" />
        </div>
        <div>
            <x-input-label for="image" :value="__('Image')" />
            <x-text-input wire:model.live="image"  id="image" name="image" type="file" class="mt-1 block w-full p-2" required autocomplete="image" />
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
