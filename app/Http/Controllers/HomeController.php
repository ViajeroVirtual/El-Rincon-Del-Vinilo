<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index() // Punto de investigación: Controlador pasa datos a la vista
    {
        $products = Product::all();
        return view('home', compact('products'));
    }
}
