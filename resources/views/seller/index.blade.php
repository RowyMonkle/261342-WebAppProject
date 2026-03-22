<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--secondary);">
            My Shop
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- PRODUCTS SECTION --}}
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">🛍️ My Products</h3>
                    <a href="{{ route('seller.products.create')}}"
                       class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 text-sm">
                        + Add Product
                    </a>
                </div>

                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left">Image</th>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Price</th>
                                <th class="px-6 py-3 text-left">Stock</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" class="w-12 h-12 object-cover rounded-lg">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg"></div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-gray-600">฿{{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4">{{ $product->stock_number }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('seller.products.edit', $product->product_id) }}"
                                           class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('seller.products.destroy', $product->product_id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure?')"
                                                class="px-3 py-1 bg-red-500 text-white rounded-lg text-xs hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No products yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ORDERS SECTION --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">📦 My Orders</h3>

                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left">Order ID</th>
                                <th class="px-6 py-3 text-left">Customer</th>
                                <th class="px-6 py-3 text-left">Products</th>
                                <th class="px-6 py-3 text-left">Total</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Payment</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($orders ?? [] as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-600">#{{ $order->order_id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 text-gray-600">
                                    @foreach($order->items as $item)
                                        <div>{{ $item->product->name }} x{{ $item->quantity }}</div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-gray-600">฿{{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $order->status === 'processing' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $order->status === 'packing' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $order->status === 'delivering' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ $order->status === 'complete' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $order->status === 'pending' ? 'bg-gray-100 text-gray-700' : '' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
    <span class="px-2 py-1 rounded-full text-xs font-semibold
        {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
        {{ $order->payment_status === 'unpaid' ? 'bg-red-100 text-red-700' : '' }}
        {{ $order->payment_status === 'refunded' ? 'bg-yellow-100 text-yellow-700' : '' }}">
        {{ $order->payment_status ?? 'unpaid' }}
    </span>
</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        @if($order->status === 'processing')
                                            <form method="POST" action="{{ route('seller.orders.packing', $order->order_id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600">
                                                    Mark Packing
                                                </button>
                                            </form>
                                        @elseif($order->status === 'packing')
                                            <form method="POST" action="{{ route('seller.orders.delivering', $order->order_id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1 bg-purple-500 text-white rounded-lg text-xs hover:bg-purple-600">
                                                    Mark Delivering
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400">No action</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>