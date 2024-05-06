<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{

    use HasFactory;

    protected $primaryKey = 'fld_rid';

    public function attenUser()
    {
        return $this->belongsTo(User::class, 'fld_uid', 'fld_uid')->where('fld_role', 2);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'fld_uid', 'fld_uid');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'fld_state_id', 'fld_sid');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'fld_did', 'fld_did');
    }

    public function tehsil()
    {
        return $this->belongsTo(Tehsil::class, 'fld_tehsil_id', 'fld_tid');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'fld_village_id', 'fld_vid');
    }

    public function retailSaleCount()
    {
        return $this->hasMany(RetailSale::class, 'fld_rid', 'fld_rid')->groupBy('fld_rid');
    }

    public function orders()
    {
        return $this->hasMany(RetailSale::class, 'fld_rid', 'fld_rid');
    }
}
