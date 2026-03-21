<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Manage Users
        </h2>
    </x-slot>

        {{-- 🌟 เพิ่ม Admin ใหม่ --}}
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
             <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <span class="text-yellow-500">👥</span> เพิ่ม Admin ใหม่
            </h2>
             <div class="bg-white rounded-3xl shadow-sm border border-pink-50 p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span>➕</span> เพิ่ม Admin ใหม่
            </h3>
            <form action="{{ route('admin.users.storeAdmin') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @csrf
                <div>
                    <input type="text" name="name" placeholder="ชื่อ-นามสกุล" required
                        class="w-full border-gray-200 rounded-xl p-2.5 text-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <input type="email" name="email" placeholder="อีเมล (Email)" required
                        class="w-full border-gray-200 rounded-xl p-2.5 text-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <input type="password" name="password" placeholder="รหัสผ่าน" required
                        class="w-full border-gray-200 rounded-xl p-2.5 text-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <button type="submit" 
                    class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2.5 px-4 rounded-xl transition shadow-lg shadow-pink-100">
                    สร้าง Admin
                </button>
            </form>
        </div>

    {{-- Request from users to become sellers --}}
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        {{-- Inbox คำขอเปิดร้าน (แสดงตลอดเวลา) --}}
        <div class="bg-white rounded-3xl shadow-sm border-2 border-pink-200 overflow-hidden relative">
            
            {{-- Header ของ Inbox --}}
            <div class="p-6 bg-pink-50 border-b border-pink-100 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-pink-800 flex items-center gap-2">
                        <span class="text-2xl">📨</span> Inbox: คำขอสิทธิ์ผู้ขาย (Seller Requests)
                    </h3>
                    <p class="text-sm text-pink-600 mt-1">ตรวจสอบและอนุมัติสิทธิ์ผู้ขาย</p>
                </div>
                
                {{-- ป้ายแจ้งเตือน (โชว์เฉพาะตอนมีคำขอ) --}}
                @if(isset($pendingRequests) && $pendingRequests->count() > 0)
                    <span class="bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm animate-bounce">
                        {{ $pendingRequests->count() }} คำขอใหม่
                    </span>
                @endif
            </div>

            {{-- เนื้อหา Inbox --}}
            @if(isset($pendingRequests) && $pendingRequests->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($pendingRequests as $req)
                        {{-- Alpine.js สำหรับเปิด/ปิด Modal ดูข้อมูล --}}
                        <div x-data="{ openForm: false }" class="p-4 hover:bg-gray-50 transition flex items-center justify-between gap-4">
                            
                            {{-- ข้อมูลย่อ --}}
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-300 to-pink-500 text-white flex items-center justify-center font-bold shadow-sm">
                                    {{ strtoupper(substr($req->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $req->user->name }} <span class="text-xs text-gray-400 font-normal ml-2">({{ $req->user->email }})</span></p>
                                    <p class="text-sm text-pink-500 font-semibold mt-0.5">ร้าน: {{ $req->shop_name }}</p>
                                </div>
                            </div>

                            {{-- ปุ่มดูข้อมูล --}}
                            <button @click="openForm = true" class="px-4 py-2 bg-white border border-pink-200 text-pink-600 font-bold rounded-full text-sm hover:bg-pink-50 hover:shadow-sm transition flex items-center gap-2">
                                <span>🔍</span> Information
                            </button>

                            {{-- Modal แสดงรายละเอียดฟอร์ม --}}
                            <div x-show="openForm" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                    <div x-show="openForm" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openForm = false"></div>

                                    <div x-show="openForm" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border-2 border-pink-100">
                                        <div class="bg-white px-6 pt-6 pb-4">
                                            <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-3">
                                                <span>🏪</span> ข้อมูลร้านค้า
                                            </h3>
                                            
                                            <div class="space-y-4 text-sm">
                                                <div><span class="text-gray-500 font-bold block mb-1">User request:</span> {{ $req->user->name }} ({{ $req->user->email }})</div>
                                                <div><span class="text-gray-500 font-bold block mb-1">Shop Name:</span> <span class="text-pink-600 font-bold text-lg">{{ $req->shop_name }}</span></div>
                                                <div><span class="text-gray-500 font-bold block mb-1">Contact:</span> {{ $req->contact_number }}</div>
                                                <div><span class="text-gray-500 font-bold block mb-1">Shop Address:</span> <div class="bg-gray-50 p-3 rounded-xl border">{{ $req->ship_address }}</div></div>
                                                <div><span class="text-gray-500 font-bold block mb-1">Shop Description:</span> <div class="bg-gray-50 p-3 rounded-xl border whitespace-pre-line">{{ $req->shop_description }}</div></div>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-gray-50 px-6 py-4 flex items-center justify-between gap-2 border-t">
                                            <button @click="openForm = false" class="px-4 py-2 text-gray-500 font-bold hover:bg-gray-200 rounded-full transition">ปิดหน้าต่าง</button>
                                            
                                            <div class="flex items-center gap-2">
                                                <form method="POST" action="{{ route('admin.sellerRequests.reject', $req->id) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" onclick="return confirm('ปฏิเสธคำขอนี้?')" class="px-5 py-2 bg-red-100 text-red-600 font-bold rounded-full hover:bg-red-200 transition"> Reject</button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.sellerRequests.approve', $req->id) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="px-5 py-2 bg-green-500 text-white font-bold rounded-full hover:bg-green-600 shadow-md transition">✅ Approve</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- จบ Modal --}}

                        </div>
                    @endforeach
                </div>
            @else
                {{-- 🌟 ถ้าไม่มีคำขอ ให้โชว์หน้านี้แทน --}}
                <div class="p-10 text-center flex flex-col items-center justify-center bg-white">
                    <div class="text-5xl mb-3 opacity-50">✨</div>
                    <h4 class="text-lg font-bold text-gray-700">ไม่มีคำขอใหม่</h4>
                    <p class="text-gray-500 mt-1">ขณะนี้ยังไม่มีผู้ใช้ส่งคำขอเปิดร้านเข้ามาครับ</p>
                </div>
            @endif
        </div>
        
        {{-- 🌟 ตารางจัดการ Users --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Role</th>
                            <th class="px-6 py-3 text-left">Joined</th>
                            <th class="px-6 py-3 text-left">Actions</th> </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
    @foreach($users as $user)
    <tr class="hover:bg-gray-50">
        {{-- 1. คอลัมน์ ID --}}
        <td class="px-6 py-4 text-gray-400 text-sm">{{ $user->id }}</td>

        {{-- 2. คอลัมน์ Name --}}
        <td class="px-6 py-4 font-medium text-gray-800 text-sm">{{ $user->name }}</td>

        {{-- 3. คอลัมน์ Email --}}
        <td class="px-6 py-4 text-gray-500 text-sm">{{ $user->email }}</td>

        {{-- 4. คอลัมน์ Role --}}
        <td class="px-6 py-4">
            <span @class([
                'px-2 py-1 rounded-full text-[10px] font-bold uppercase',
                'bg-red-100 text-red-700'   => $user->role === 'admin',
                'bg-blue-100 text-blue-700' => $user->role === 'customer',
            ])>
                {{ $user->role }}
            </span>
        </td>

        {{-- 5. คอลัมน์ Joined --}}
        <td class="px-6 py-4 text-gray-400 text-sm">{{ $user->created_at->format('d/m/Y') }}</td>

        {{-- 6. คอลัมน์ Actions (ปุ่มกด) --}}
        <td class="px-6 py-4">
            <div class="flex items-center gap-2">
                @if($user->id !== Auth::id())
                    <form method="POST" action="{{ route('admin.users.updateRole', $user->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-3 py-1 bg-amber-100 text-amber-600 rounded-lg text-xs font-bold hover:bg-amber-200 transition">
                            Change Role
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('แน่ใจนะว่าจะลบ?')" 
                                class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-xs font-bold hover:bg-red-200 transition">
                            Delete
                        </button>
                    </form>
                @else
                    <span class="text-xs text-gray-300 italic">Current Admin</span>
                @endif
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>