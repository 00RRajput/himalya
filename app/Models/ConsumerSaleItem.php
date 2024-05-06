<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumerSaleItem extends Model
{
    protected $table = 'consumer_sales_items';
    protected $primaryKey = 'fld_csid';
    public $timestamps = false;

    protected $hidden = ['fld_created_at', 'fld_updated_at'];

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'fld_uid', 'fld_uid');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'fld_pid', 'fld_pid');
    }
}
