<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function blog()
    {
        return view('contents.blog');
    }

    public function promotion()
    {
        return view('contents.promotion');
    }

    public function tips()  
    {
        return view('contents.tips');
    }
    
    
}
