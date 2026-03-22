<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--secondary);">
            Edit Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <form method="POST" action="{{ route('seller.products.update', $product->product_id) }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

                    {{-- Name --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">{{ old('description', $product->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Price --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price (฿)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Stock --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                        <input type="number" name="stock_number" value="{{ old('stock_number', $product->stock_number) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                        @error('stock_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Image --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        @if($product->image)
                            <img src="{{ $product->image }}" class="w-24 h-24 object-cover rounded-lg mb-2">
                        @endif
                        <input type="file" name="image" accept="image/*"
                            class="w-full text-sm text-gray-500">
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3 justify-end">
                        <a href="{{ route('seller.index') }}"
                           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-pink-500 text-white rounded-lg text-sm hover:bg-pink-600">
                            Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>