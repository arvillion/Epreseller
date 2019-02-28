<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = \Auth::user()->role->products()->paginate(10);
        return view('user.product.index')->withProducts($products);
    }

    public function showJson($id){
        $product = \Auth::user()->role->products()->findOrFail($id);
        $servers = $product->servers;
        return view('user.product.json', ['product' => $product, 'servers' => $servers]);
    }

    public function show($id){
        $product = \Auth::user()->role->products()->findOrFail($id);
        $servers = $product->servers;
        return view('user.product.show', ['product' => $product, 'servers' => $servers]);
    }
}