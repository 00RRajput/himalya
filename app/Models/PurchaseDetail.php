<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    protected $table = "purchases";

    public function attenUser()
    {
        return $this->belongsTo(User::class, 'fld_uid', 'fld_uid');
    }

    public function stockiest()
    {
        return $this->belongsTo(Stockiest::class, 'fld_sid', 'fld_sid');
    }

    public function items()
    {
        return $this->hasMany(PurchaseDetailItem::class, 'fld_prid', 'fld_prid');
    }
}
