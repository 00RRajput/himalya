<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    use HasFactory;
    protected $table = "products_historys";
    protected $primaryKey = 'fld_phid';
    const CREATED_AT = 'fld_created_at';
    const UPDATED_AT = 'fld_updated_at';
    protected $fillable = [
        'fld_uid', 'fld_pid', 'fld_remark', 'fld_path', 'fld_file', 'fld_type', 'fld_status', 'fld_display_order'
    ];
    public function attenUser()
    {
        return $this->belongsTo(User::class, 'fld_uid', 'fld_uid')->where('fld_role', 2);
    }
}
