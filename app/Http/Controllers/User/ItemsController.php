<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\PrimaryCategory;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next){
            $itemId = $request->route()->parameter('item');
            if (!empty($itemId)) {
                $exists = Product::availableItems()->where('products.id', $itemId)->exists();
                if (!$exists) abort(404);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $products = Product::availableItems()
            ->selectCategory()
            ->searchKeyword()
            ->sortOrder()
            ->paginate(\Request::get('pagination') ?? 20);
        $categories = PrimaryCategory::with('secondaries')->orderBy('sort_order')->get();
        return view('user.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $maxQuantity = $product->salesQuantity();
        if ($maxQuantity > 9) $maxQuantity = 9;

        return view('user.show', compact('product', 'maxQuantity'));
    }
}
