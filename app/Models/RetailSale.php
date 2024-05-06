<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetailSale extends Model
{
    protected $table = 'retail_sales';
    protected $primaryKey = 'fld_rsid';
    public $timestamps = false;

    protected $hidden = ['fld_created_at', 'fld_updated_at'];

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'fld_uid', 'fld_uid');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'fld_pid', 'fld_pid');
    }

    public function items()
    {
        return $this->hasMany(RetailSaleItem::class, 'fld_rsid', 'fld_rsid');
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class, 'fld_rid', 'fld_rid');
    }
}
