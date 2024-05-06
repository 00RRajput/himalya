<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetailSaleItem extends Model
{
    protected $table = 'retail_sales_items';
    protected $primaryKey = 'fld_rsiid';
    public $timestamps = false;

    protected $hidden = ['fld_created_at', 'fld_updated_at'];

    protected $guarded = [];

    public function retailerSale()
    {
        return $this->belongsTo(RetailSale::class, 'fld_csid', 'fld_rsid');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'fld_pid', 'fld_pid');
    }
}
