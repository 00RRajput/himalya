<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'x_states';

    protected $hidden = ['fld_created_at', 'fld_updated_at'];

    public function districts()
    {
        return $this->hasMany(District::class, 'fld_state_id', 'fld_sid');
    }

    public function villages()
    {
        return $this->hasManyThrough(Village::class, District::class, 'fld_state_id', 'fld_district_id', 'fld_state_id', 'fld_did');
    }
}
