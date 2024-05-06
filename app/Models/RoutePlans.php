<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutePlan extends Model
{
    use HasFactory;

    protected $primaryKey = 'fld_rpid';
    const CREATED_AT = 'fld_created_at';
    const UPDATED_AT = 'fld_updated_at';

    public function attenUser()
    {
        return $this->belongsTo(User::class, 'fld_uid', 'fld_uid')->where('fld_role', 2);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'fld_pid', 'fld_pid');
    }
}
