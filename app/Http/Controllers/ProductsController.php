<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all()->take(2);
        $products = Product::all()->take(6);
        $userRating = $product->getUserRating();
        return view('products.show', compact('product', 'userRating'));
    }

    public function addRating(Request $request, Product $product)
    {
        $product->rateOnce($request->get('star'));

        return redirect()->back();
    }
}
