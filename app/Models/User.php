<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'fld_uid';
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
        'fld_name',
        'fld_username',
        'fld_password',
        'fld_state_id',
        'fld_role',
        'fld_status',
        'fld_project_id',
        'fl_password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'fl_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function routePlan()
    {
        return $this->hasMany(RoutePlan::class, 'fld_uid', 'fld_uid')->groupby('fld_district_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'fld_state_id', 'fld_sid');
    }

    public function totalRetailers()
    {
        return $this->hasMany(Retailer::class, 'fld_uid', 'fld_uid');
    }

    public function total_retailsales()
    {
        return $this->hasMany(RetailSale::class, 'fld_uid', 'fld_uid');
    }

    public function total_purchase()
    {
        return $this->hasMany(PurchaseDetail::class, 'fld_uid', 'fld_uid');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'fld_uid', 'fld_uid');
    }
}
