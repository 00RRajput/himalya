<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    protected $primaryKey = 'fld_cfid';
    protected $table = 'x_fields';
    const CREATED_AT = 'fld_created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'fld_updated_at';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['fld_pid', 'fld_question', 'fld_placeholder', 'fld_ans', 'fld_display_order', 'fld_type', 'fld_required', 'fld_status'];


    public function project()
    {
        return $this->belongsTo(Project::class, 'fld_pid', 'fld_pid');
    }
}
