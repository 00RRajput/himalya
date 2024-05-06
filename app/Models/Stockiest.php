<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stockiest extends Model
{
    protected $table = 'stockists';
    protected $primaryKey = 'fld_sid';
    public $timestamps = false;

    protected $hidden = ['fld_created_at', 'fld_updated_at'];

    protected $guarded = [];

    public function state()
    {
        return $this->belongsTo(State::class, 'fld_state_id', 'fld_sid');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'fld_did', 'fld_did');
    }

    public function project()
    {
        return $this->belongsTo(Tehsil::class, 'fld_pid', 'fld_pid');
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseDetail::class, 'fld_sid', 'fld_sid');
    }
}
