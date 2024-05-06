<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
    protected $fillable = [
        'fld_p_id',
        'fld_name',
        'fld_type',
        'fld_status',
        'fld_sku',
        'fld_display_order',
        'fld_mrp',
        'fld_cost_price',
        'fld_selling_price'
    ];
}
