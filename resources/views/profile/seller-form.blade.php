<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--secondary);">
            {{ __('Register as Seller') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: var(--bg);">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            {{-- ปุ่มกลับ --}}
            <div class="mb-6">
                <a href="{{ route('profile.index') }}" class="text-sm font-medium flex items-center gap-2 text-gray-500 hover:text-pink-500 transition">
                    <span>←</span> back to Profile
                </a>
            </div>

            {{-- การ์ดฟอร์ม --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-pink-50">
                
                {{-- หัวข้อ --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-pink-50 text-3xl mb-4 shadow-inner">
                        🏪
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Your Shop Information</h1>
                    <p class="text-sm text-gray-500 mt-2">Fill in the details completely for the admin to consider your seller application.</p>
                </div>

                {{-- ฟอร์ม --}}
                
                <form method="POST" action="{{ route('seller.form.store') }}" class="space-y-6">
                    @csrf

                    {{-- ชื่อร้าน --}}
                    <div>
                        <label for="shop_name" class="block text-sm font-bold text-gray-700 mb-1">
                            ชื่อร้าน (Shop Name) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="shop_name" id="shop_name" value="{{ old('shop_name') }}" required
                            class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-pink-500 focus:border-pink-500 transition"
                            placeholder="ตั้งชื่อร้านที่น่าจดจำ...">
                        
                        {{-- แสดง Error ถ้าชื่อซ้ำหรือลืมกรอก --}}
                        @error('shop_name')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- รายละเอียดร้าน --}}
                    <div>
                        <label for="shop_description" class="block text-sm font-bold text-gray-700 mb-1">
                            รายละเอียดร้าน (Description) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="shop_description" id="shop_description" rows="4" required
                            class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-pink-500 focus:border-pink-500 transition"
                            placeholder="Tell us about your shop or the types of products you will sell...">{{ old('shop_description') }}</textarea>
                        
                        @error('shop_description')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- เบอร์ติดต่อ --}}
                    <div>
                        <label for="contact_number" class="block text-sm font-bold text-gray-700 mb-1">
                            Contact Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" required
                            class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-pink-500 focus:border-pink-500 transition"
                            placeholder="08X-XXX-XXXX">
                        
                        @error('contact_number')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ที่อยู่จัดส่ง/ที่ตั้งร้าน --}}
                    <div>
                        <label for="ship_address" class="block text-sm font-bold text-gray-700 mb-1">
                            ที่ตั้งร้าน / ที่อยู่จัดส่ง (Shipping Address) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="ship_address" id="ship_address" rows="3" required
                            class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-pink-500 focus:border-pink-500 transition"
                            placeholder="บ้านเลขที่, ถนน, ตำบล, อำเภอ, จังหวัด, รหัสไปรษณีย์...">{{ old('ship_address') }}</textarea>
                        
                        @error('ship_address')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ปุ่ม Submit --}}
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full py-3.5 px-4 text-white font-bold rounded-full transition-transform hover:scale-[1.02] hover:shadow-lg flex items-center justify-center gap-2"
                                style="background: linear-gradient(135deg, var(--primary), var(--secondary));">
                            <span>🚀</span> submit the request
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>