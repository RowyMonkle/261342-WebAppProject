<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerForm;
use App\Models\SellerRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerFormController extends Controller
{
    public function store(Request $request)
    {
    $request->validate([
            'shop_name' => 'required|string|max:255|unique:seller_forms,shop_name',
            'shop_description' => 'required|string|max:1000',
            'contact_number' => 'required|string|max:15',
            'ship_address' => 'required|string', // 🌟 1. เพิ่ม Validate ตรงนี้
        ], [
            'shop_name.unique' => 'This shop name is already taken. Please choose another one.',
            'contact_number.required' => 'Please fill in the phone number.',
            'ship_address.required' => 'Please fill in the shipping address.' // แจ้งเตือนถ้าลืมกรอก
        ]);

        SellerForm::create([
            'user_id' => Auth::id(),
            'shop_name' => $request->shop_name,
            'shop_description' => $request->shop_description,
            'contact_number' => $request->contact_number,
            'ship_address' => $request->ship_address, // 🌟 2. เพิ่มบันทึกลง Database
            'status' => 'pending'
        ]);

        return redirect()->route('profile.index')->with('success', 'Request submitted successfully! Please wait for the admin to review it.');
    }

    public function create()
    {
        // check profile status before showing the form (already seller/admin or already submitted a request)
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.index')->with('success', 'You are already a seller/admin.');
        }

        $existingForm = SellerForm::where('user_id', Auth::id())
                                  ->whereIn('status', ['pending'])
                                  ->first();
                                  
        if ($existingForm) {
            return redirect()->route('profile.index')->with('error', 'You have already submitted a request. Please wait for the admin to review it.');
        }

        return view('profile.seller-form'); // form for requesting seller access 
    }

    
}
