<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    protected $table = 'consumers';
    protected $primaryKey = 'fld_cid';
    public $timestamps = false;

    protected $hidden = ['fld_updated_at'];

    protected $guarded = [];

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
    public function sales()
    {
        return $this->belongsTo(ConsumerSale::class, 'fld_cid', 'fld_cid');
    }
}
