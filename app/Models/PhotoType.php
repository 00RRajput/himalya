<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoType extends Model
{
    use HasFactory;

    protected $table = 'x_ptypes';
    protected $primaryKey = 'fld_ptid';
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

    protected $fillable = ['fld_purpose', 'fld_type', 'fld_status'];
}
