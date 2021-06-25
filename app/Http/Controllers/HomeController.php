<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $id = auth()->user()->id;
        $products = Product::where('user_id', $id)->paginate(10);

        if (auth()->user()->role != 'user') {
            return redirect('/manager/dashboard');
        } else {
            return view('products/index', compact('products'));
        }
    }
}
