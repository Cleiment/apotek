<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'qty', 'is_out', 'from_or_to'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
