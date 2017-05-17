<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    //唐诗首页展示
    public function index()
    {
		return view('index.index');
    }
}
