<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $primaryKey = 'fld_pid';
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
    protected $fillable = ['fld_name', 'fld_sale_type', 'fld_start_date', 'fld_consumer_sales', 'fld_activity_photos', 'fld_status'];


    public function routePlans()
    {
        return $this->hasMany(RoutePlan::class, 'fld_pid', 'fld_pid');
    }
}
