<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Shop;
use App\Models\Image;
use App\Models\Stock;
use App\Models\PrimaryCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware(function($request, $next){
            $productId = $request->route()->parameter('product');
            if (!empty($productId)) {
                $ownerId = Product::findOrFail($productId)->shop->owner->id;
                if ($ownerId !== Auth::id()) abort(404);
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopIds = Shop::where('owner_id', Auth::id())->pluck('id')->toArray();
        $products = Product::whereIn('shop_id', $shopIds)
            ->orderBy('sort_order')->get();

            return view('owner.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = Shop::where('owner_id', Auth::id())->orderBy('created_at')
            ->get();
        $images = Image::where('owner_id', Auth::id())->orderBy('created_at')
            ->get();
        $primaries = PrimaryCategory::with('secondaries')->orderBy('sort_order')->get();

        return view('owner.products.create', compact('shops', 'images', 'primaries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        DB::transaction(function() use($request){
            $product = Product::create([
                'name' => $request->name,
                'information' => $request->information,
                'price' => $request->price,
                'sort_order' => $request->sort_order,
                'is_selling' => $request->is_selling,
                'shop_id' => $request->shop,
                'secondary_category_id' => $request->category,
                'image1_id' => $request->image1,
                'image2_id' => $request->image2,
                'image3_id' => $request->image3,
                'image4_id' => $request->image4,
            ]);
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_ADD,
                'quantity' => $request->quantity,
            ]);
        });

        session()->flash('status', 'info');
        session()->flash('message', '商品を登録しました。');
        return to_route('owner.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     dd(__FUNCTION__);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shops = Shop::where('owner_id', Auth::id())->orderBy('created_at')
            ->get();
        $images = Image::where('owner_id', Auth::id())->orderBy('created_at')
            ->get();
        $primaries = PrimaryCategory::with('secondaries')->orderBy('sort_order')->get();

        $product = Product::with(['shop','category','image1','image2','image3','image4'])->findOrFail($id);
        $quantity = $product->stocks->sum('quantity');

        return view('owner.products.edit', compact('shops', 'images', 'primaries', 'product', 'quantity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $request->validate([
            'current_quantity' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $currentQuantity = $product->stocks->sum('quantity');

        if ((int)$request->current_quantity !== $currentQuantity) {
            session()->flash('status', 'alert');
            session()->flash('message', '現在在庫数が変更されています。再度確認してください。');
        }

        DB::transaction(function() use($request, $product){
            $product->name = $request->name;
            $product->information = $request->information;
            $product->price = $request->price;
            $product->sort_order = $request->sort_order;
            $product->is_selling = $request->is_selling;
            $product->shop_id = $request->shop;
            $product->secondary_category_id = $request->category;
            $product->image1_id = $request->image1;
            $product->image2_id = $request->image2;
            $product->image3_id = $request->image3;
            $product->image4_id = $request->image4;
            $product->save();

            if ((int)$request->quantity > 0) {
                if ($request->type === \Constant::PRODUCT_ADD) {
                    $newQuantity = $request->quantity;
                } elseif ($request->type === \Constant::PRODUCT_REDUCE) {
                    $newQuantity = -1 * $request->quantity;
                }

                Stock::create([
                    'product_id' => $product->id,
                    'type' => $request->type,
                    'quantity' => $newQuantity,
                ]);
            }
        });

        session()->flash('status', 'info');
        session()->flash('message', '商品情報を更新しました。');
        return to_route('owner.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        session()->flash('status', 'alert');
        session()->flash('message', '商品情報を削除しました。');
        return to_route('owner.products.index');
    }
}
