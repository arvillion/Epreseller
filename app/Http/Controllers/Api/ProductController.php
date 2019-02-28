<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function show(){
        return \Auth::user()->role->products()->select('product_id as id', 'name')->get();
    }
}
