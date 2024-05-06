<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    public function attenUser()
    {
        return $this->belongsTo(User::class, 'fld_uid', 'fld_uid');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'fld_pid', 'fld_pid');
    }


    public function state()
    {
        return $this->belongsTo(State::class, 'fld_state_id', 'fld_sid');
    }

    public function usersummeries()
    {
        return $this->hasMany(UserSummary::class, 'fld_uid', 'fld_uid');
    }
}
