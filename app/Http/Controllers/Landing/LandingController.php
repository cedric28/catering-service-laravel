<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class LandingController extends Controller
{
    public function index(){
        $products = Product::all();

        return view('welcome',[
            'products' => $products
        ]);
    }
}
