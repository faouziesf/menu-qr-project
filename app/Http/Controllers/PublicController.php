<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function showMenu($slug)
    {
        $menu = Menu::where('slug', $slug)->firstOrFail();
        
        return view('public.menu', compact('menu'));
    }
}