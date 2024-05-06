<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityReport extends Model
{
    use HasFactory;

    public function attenUser()
    {
        return $this->belongsTo(User::class, 'fld_uid', 'fld_uid')->where('fld_role', 2);
    }
}
