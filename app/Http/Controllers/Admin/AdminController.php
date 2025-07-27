<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $menus = Menu::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('menus'));
    }
}