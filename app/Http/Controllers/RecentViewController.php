<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecentView;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RecentViewController extends Controller
{
    public function index()
    {
        $recentViews = RecentView::where('user_id', Auth::id())
            ->with('product') 
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedViews = $recentViews->groupBy(function ($item) {
            $date = Carbon::parse($item->created_at);
            
            if ($date->isToday()) {
                return 'Today';
            } elseif ($date->isYesterday()) {
                return 'Yesterday';
            }
            
            return $date->format('d M Y');
        });

        // 3. ส่งข้อมูลไปที่หน้า recentView.index.blade.php
        return view('recentView.index', compact('groupedViews'));
    }
}