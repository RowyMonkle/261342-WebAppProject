<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--secondary);">
            {{ __('Recently Viewed') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: var(--bg);">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Header & Back Button --}}
            <div class="flex items-center gap-2 mb-6">
               <a href="{{ route('profile.index') }}" class="text-sm text-gray-500 hover:underline transition">← Back to Profile</a>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <span class="text-yellow-500">🕒</span>
                สินค้าที่เพิ่งดู ({{ $groupedViews->flatten()->count() }} รายการ)
            </h1>

            {{-- วนลูปกลุ่มตามวันที่ (Today, Yesterday, Date) --}}
            @forelse($groupedViews as $date => $views)
                
                {{-- ป้ายคั่นบอกวันที่ --}}
                <div class="mt-8 mb-4 flex items-center gap-3">
                    <span class="px-4 py-1.5 bg-white border border-pink-100 rounded-full text-xs font-bold text-gray-600 shadow-sm">
                        📅 {{ $date }}
                    </span>
                    <div class="h-px bg-gray-200 flex-1 opacity-50"></div>
                </div>

                {{-- รายการสินค้าในวันนั้นๆ --}}
                <div class="space-y-4">
                    @foreach($views as $view)
                        {{-- เช็คกันเหนียว เผื่อสินค้านั้นถูกแอดมินลบออกจากระบบไปแล้ว --}}
                        @if($view->product)
                            <div class="bg-white rounded-3xl shadow-sm border border-pink-50 p-4 flex items-center gap-4 transition-all hover:shadow-md hover:-translate-y-0.5">

                                {{-- รูปสินค้า --}}
                                <div class="w-24 h-24 rounded-2xl overflow-hidden flex-shrink-0 relative bg-gray-50 border border-gray-100">
                                    @if($view->product->image)
                                        @php
                                            $imageUrl = str_starts_with($view->product->image, 'http')
                                                ? $view->product->image
                                                : route('product.photo', ['filename' => basename($view->product->image)]);
                                        @endphp
                                        <img src="{{ $imageUrl }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-2xl">📸</div>
                                    @endif
                                </div>

                                {{-- ข้อมูลสินค้า --}}
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-gray-800 truncate text-lg">{{ $view->product->name }}</p>
                                    <p class="font-extrabold mt-1" style="color: var(--secondary);">
                                        ฿{{ number_format($view->product->price, 2) }}
                                    </p>
                                    <p class="text-[11px] text-gray-400 mt-1.5 flex items-center gap-1">
                                        <span>👁️</span> ดูเมื่อเวลา {{ \Carbon\Carbon::parse($view->created_at)->format('H:i') }} น.
                                    </p>
                                </div>

                                {{-- ปุ่ม Add to Cart (ไม่มีปุ่มลบ ตาม Request) --}}
                                <div class="flex items-center gap-2 pr-2">
                                    @if($view->product->stock_number > 0)
                                        <form method="POST" action="{{ route('carts.store') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $view->product->product_id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit"
                                                class="flex items-center justify-center gap-2 px-5 py-2.5 text-white text-sm font-bold rounded-full transition-transform hover:scale-105 hover:shadow-md"
                                                style="background: var(--primary);">
                                                <span>🛒</span> <span class="hidden sm:inline">Add to Cart</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="px-4 py-2 bg-gray-100 text-gray-400 text-sm font-bold rounded-full">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>

                            </div>
                        @endif
                    @endforeach
                </div>

            @empty
                {{-- หน้าจอว่างเปล่า กรณีที่ยังไม่เคยดูสินค้าเลย --}}
                <div class="bg-white rounded-3xl shadow-sm border border-pink-50 p-12 text-center flex flex-col items-center gap-4 mt-8">
                    <div class="text-6xl mb-2">👻</div>
                    <h3 class="text-xl font-bold text-gray-800">ยังไม่มีประวัติการเข้าชม</h3>
                    <p class="text-gray-500 text-sm">คุณยังไม่ได้คลิกดูสินค้าชิ้นไหนเลย ลองไปค้นหาสินค้าที่ถูกใจดูสิ!</p>
                    <a href="{{ route('products.index') }}" 
                       class="px-8 py-3 text-white font-bold rounded-full mt-4 transition hover:shadow-lg hover:-translate-y-1" 
                       style="background: linear-gradient(135deg, var(--primary), var(--secondary));">
                        ช้อปปิ้งเลย
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>