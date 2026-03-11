<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                <div class="md:flex">
                    {{-- รูปสินค้า --}}
                    <div class="md:w-1/2">
                        @if ($product->image)
                            <img src="{{ asset('storage/products/' . $product->image) }}" 
                                 class="w-full h-96 object-cover">
                        @else
                            <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        @endif
                    </div>

                    {{-- ข้อมูลสินค้า --}}
                    <div class="md:w-1/2 p-6 space-y-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</h1>
                        <p class="text-3xl font-bold text-green-600">฿{{ number_format($product->price, 2) }}</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $product->description }}</p>
                        <p class="text-sm text-gray-500">คงเหลือ: {{ $product->stock_number }}</p>

                        @if ($product->stock_number > 0)
                            <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                                เพิ่มลงตะกร้า
                            </button>
                        @else
                            <button disabled class="w-full bg-gray-400 text-white py-2 px-4 rounded-lg">
                                สินค้าหมด
                            </button>
                        @endif

                        <a href="{{ route('products.index') }}" class="block text-center text-gray-500 hover:underline mt-2">
                            ← กลับไปหน้าสินค้า
                        </a>