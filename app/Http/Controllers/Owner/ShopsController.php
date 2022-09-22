<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use App\Providers\ImageService;
use App\Http\Requests\uploadImageRequest;

class ShopsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            $shopId = $request->route()->parameter('shop');
            if (isset($shopId)) {
                $ownerId = Shop::findOrFail($shopId)->owner->id;
                if ($ownerId !== Auth::id()) abort(404);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $shops = Shop::where('owner_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('owner.shops.index', compact('shops'));
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        return view('owner.shops.edit', compact('shop'));
    }

    public function update(uploadImageRequest $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'information' => 'required|string|max:1000',
            'is_selling' => 'required',
        ]);

        $shop = Shop::findOrFail($id);

        $imageFile = $request->file('image');
        if (isset($imageFile) && $imageFile->isValid()) {
            $filename = ImageService::upload($imageFile, 'shops');
            $shop->filename = $filename;
        }

        $shop->name = $request->name;
        $shop->information = $request->information;
        $shop->is_selling = $request->is_selling;
        $shop->save();

        session()->flash('status', 'info');
        session()->flash('message', 'ショップ情報を更新しました。');

        return to_route('owner.shops.index');
    }
}
