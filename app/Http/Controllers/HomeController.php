<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    //

    public function index()
    {
        // Obtener todos los productos
        $products = Product::all();

        // Retornar la vista de inicio con los productos
        return view('home', compact('products'));
    }
}
