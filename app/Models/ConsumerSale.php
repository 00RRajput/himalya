<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumerSale extends Model
{
    protected $table = 'consumer_sales';
    protected $primaryKey = 'fld_csid';
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
        return $this->hasMany(ConsumerSaleItem::class, 'fld_csid', 'fld_csid');
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class, 'fld_cid', 'fld_cid');
    }
}
