<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $products = User::findOrFail(Auth::id())->products;
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }
        return view('user.cart', compact('products', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        if ($product->salesQuantity() <= 0) {
            session()->flash('status', 'alert');
            session()->flash('message', "申し訳ございません。現在 商品「{$product->name}」 販売在庫数が不足しています。");
            return to_route('user.items.index');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)->first();
        if (empty($cart)) {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        } else {
            $cart->quantity += $request->quantity;
            $cart->save();
        }

        return to_route('user.cart.index');
    }

    public function destroy($id)
    {
        Cart::where('user_id', Auth::id())->where('product_id', $id)->delete();
        session()->flash('status', 'alert');
        session()->flash('message', "商品を削除しました。");
        return to_route('user.cart.index');
}

    public function checkout()
    {
        $products = User::findOrFail(Auth::id())->products;

        // カートが空ならフラッシュ付けて戻す
        if (empty($products)) {
            session()->flash('status', 'alert');
            session()->flash('message', "カートが空のため購入できません。");
            return to_route('user.cart.index');
            }

        // 販売在庫数が足りないならフラッシュつけてカート表示に戻す
        foreach ($products as $product) {
            $salesQuantity = $product->salesQuantity();
            if ($salesQuantity <= 0) {
                if ($salesQuantity < 0) $salesQuantity = 0;
                session()->flash('status', 'alert');
                session()->flash('message', "商品{$product->name}の在庫が足りません。残りの販売数は {$salesQuantity}個 です。");
                return to_route('user.cart.index');
            }
        }

        $lineItems = [];
        foreach ($products as $product) {
            $lineItems[] = [
                'quantity' => $product->pivot->quantity,
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $product->price,
                    'product_data' => [
                        'name' => $product->name,
                    ],
                ],
            ];
        }
        // dd($lineItems,
        //     route('user.cart.success'),
        //     route('user.cart.cancel')
        //  );

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        header('Content-Type: application/json');

        $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => $lineItems,
        'mode' => 'payment',
        'success_url' => route('user.cart.success'),
        'cancel_url' => route('user.cart.cancel'),
        ]);

        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);
        exit;
    }

    public function success()
    {
        $products = User::findOrFail(Auth::id())->products;
        // Stockからカートぶんの数量をマイナスで加える
        foreach ($products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_REDUCE,
                'quantity' => -1 * $product->pivot->quantity,
            ]);
        }
        // カートを空にする
        Cart::where('user_id', Auth::id())->delete();

        session()->flash('status', 'info');
        session()->flash('message', '商品の購入が完了しました。');
        return to_route('user.cart.index');
    }

    public function cancel()
    {
        return to_route('user.cart.index');
    }
}
