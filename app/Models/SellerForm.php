<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerForm extends Model 
// This model represents the form data submitted by users who want to become sellers.
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_description',
        'ship_address',
        'contact_number',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}