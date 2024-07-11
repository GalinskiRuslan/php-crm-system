<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_photo extends Model
{
    use HasFactory;
    public function items()
    {
        return $this->belongsTo(Item::class);
    }
    protected $fillable = [
        'item_id',
        'path',
    ];
}
