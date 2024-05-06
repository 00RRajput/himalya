<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutePlansHistory extends Model
{
    use HasFactory;
    protected $table = "route_plans_historys";
    protected $primaryKey = 'fld_rphid';
    const CREATED_AT = 'fld_created_at';
    const UPDATED_AT = 'fld_updated_at';
    protected $fillable = [
        'fld_uid', 'fld_rphid ', 'fld_pid', 'fld_file_path', 'fld_file_name', 'fld_remark'
    ];
    public function attenUser()
    {
        return $this->belongsTo(User::class, 'fld_uid', 'fld_uid')->where('fld_role', 2);
    }
}
