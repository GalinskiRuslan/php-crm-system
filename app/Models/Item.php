<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public function item_photos()
    {
        return $this->hasMany(Item_photo::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brands::class);
    }
    protected $fillable = [
        'name',
        'description',
        'price',
        'subcategory_id',
        'brand_id',
        'status',
        'count'
    ];
}
