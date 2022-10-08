<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
