<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SurfSideMedia\ShoppingCart\Facades\Cart;


class CartController extends Controller
{
    Public function index()
    {
        $items =Cart::instance('cart')->content();
        return view('cart',compact('items'));

    }
}
