<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use App\Models\Cart;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'information',
        'price',
        'sort_order',
        'is_selling',
        'shop_id',
        'secondary_category_id',
        'image1_id',
        'image2_id',
        'image3_id',
        'image4_id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function image1()
    {
        return $this->belongsTo(Image::class, 'image1_id', 'id')->withDefault();
    }
    public function image2()
    {
        return $this->belongsTo(Image::class, 'image2_id', 'id')->withDefault();
    }
    public function image3()
    {
        return $this->belongsTo(Image::class, 'image3_id', 'id')->withDefault();
    }
    public function image4()
    {
        return $this->belongsTo(Image::class, 'image4_id', 'id')->withDefault();
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'carts', 'product_id', 'user_id')
            ->withPivot('id', 'quantity');
    }

    public function salesQuantity()
    {
        $productId = $this->id;
        $stockQuantity = Stock::where('product_id', $productId)->sum('quantity');
        $cartQuantity = Cart::where('product_id', $productId)->sum('quantity');

        return $stockQuantity - $cartQuantity;
    }


    public function scopeAvailableItems($query)
    {
        $stocks = Stock::select(
            'product_id',
            DB::raw('SUM(quantity) AS quantity'),
            )
            ->groupBy('product_id');

        // leftJoin cart数量が必要
        $carts = Cart::select(
            'product_id',
            DB::raw('SUM(quantity) AS quantity'),
            )
            ->groupBy('product_id');

        return $query
            ->joinSub($stocks, 'stocks', function($join){
                $join->on('products.id', '=', 'stocks.product_id');
            })
            ->leftJoinSub($carts, 'carts', function($join){
                $join->on('products.id', '=', 'carts.product_id');
            })
            ->join('secondary_categories', 'products.secondary_category_id', '=', 'secondary_categories.id')
            ->join('images AS image1', 'products.image1_id', '=', 'image1.id')
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->select(
                'products.id AS id',
                'products.name AS name',
                'products.information AS information',
                'products.price AS price',
                'products.sort_order AS sort_order',
                'stocks.quantity AS stock_quantity',
                DB::raw('IFNULL(carts.quantity, 0) AS cart_quantity'),
                DB::raw('stocks.quantity - IFNULL(carts.quantity, 0) AS sales_quantity'),
                'secondary_categories.name AS category_name',
                'image1.filename AS image1_filename',
                'products.created_at AS created_at',
            )
            ->where('stocks.quantity', '>=', 1)
            ->where('products.is_selling', true)
            ->where('shops.is_selling', true)
            ->having('sales_quantity', '>=', 1);
    }

    public function scopeSelectCategory($query)
    {
        $category = \Request::get('category');
        if (empty($category)) return $query;
        return $query->where('products.secondary_category_id', $category);
    }

    public function scopeSearchKeyword($query)
    {
        $keyword = \Request::get('keyword');
        if (empty($keyword)) return $query;

        $keyword = mb_convert_kana($keyword, 's');
        $words = explode(' ', $keyword);
        foreach ($words as $word) {
            $query->where('products.name', 'like', "%{$word}%");
        }
        return $query;
    }

    public function scopeSortOrder($query)
    {
        $sort_order = \Request::get('sort_order');
        if (empty($sort_order)) $sort_order = \Constant::SORT_RECOMMEND;

        if($sort_order === \Constant::SORT_RECOMMEND) return $query->orderBy('products.sort_order', 'asc');

        if($sort_order === \Constant::SORT_HIGHER_PRICE) return $query->orderBy('products.price', 'desc');
        if($sort_order === \Constant::SORT_LOWER_PRICE) return $query->orderBy('products.price', 'asc');

        if($sort_order === \Constant::SORT_LATEST) return $query->orderBy('products.created_at', 'desc');
        if($sort_order === \Constant::SORT_OLDER) return $query->orderBy('products.created_at', 'asc');
    }
}
