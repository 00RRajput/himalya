<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSummary extends Model
{
    use HasFactory;

    protected $primaryKey = 'fld_sid';
    protected $table = 'summaries';
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


    public function project()
    {
        return $this->belongsTo(Project::class, 'fld_pid', 'fld_pid');
    }
}
