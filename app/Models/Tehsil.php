<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tehsil extends Model
{
    protected $table = 'x_tehsils';
    protected $primaryKey = 'fld_tid';
    public $timestamps = false;

    protected $hidden = ['fld_created_at', 'fld_updated_at'];

    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo(District::class, 'fld_district_id', 'fld_did');
    }

    public function state()
    {
        // Assuming District model has state_id as foreign key
        return $this->belongsTo(State::class, 'fld_state_id', 'fld_sid');
    }
}
