<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table = 'x_villages';
    protected $primaryKey = 'fld_vid';
    public $timestamps = false;

    protected $hidden = ['fld_created_at', 'fld_updated_at'];

    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo(District::class, 'fld_district_id', 'fld_did');
    }

    public function tehsil()
    {
        return $this->belongsTo(Tehsil::class, 'fld_tehsil_id', 'fld_tid');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'fld_state_id', 'fld_sid');
    }
}
