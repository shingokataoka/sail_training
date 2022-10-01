<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'primary_category_id',
        'name',
        'sort_order',
    ];

    public function primary()
    {
        return $this->belongsTo(PrimaryCategory::class, 'primary_category_id');
    }

}
