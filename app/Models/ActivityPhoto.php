<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityPhoto extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'fld_uid', 'fld_uid');
    }
}
