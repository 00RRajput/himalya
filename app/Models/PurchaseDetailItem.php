<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetailItem extends Model
{
    use HasFactory;
    protected $table = "purchases_items";

    public function product()
    {
        return $this->belongsTo(Product::class, 'fld_product_id', 'fld_pid');
    }
}
