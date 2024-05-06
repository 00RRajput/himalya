<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = "x_districts";
    protected $primaryKey = 'fld_did';
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
    protected $fillable = [
        'fld_state_id',
        'fld_district',
        "fld_status"
    ];


    public function state()
    {
        return $this->belongsTo(State::class, 'fld_state_id', 'fld_sid');
    }
}
