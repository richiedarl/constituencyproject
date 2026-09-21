<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function about(){
    return view('about');
}
public function documentation(){
    return view('documentation');
}

public function services(){
    return view('services');
}

public function testimonials()
{
    return redirect()->route('services');
}

}
