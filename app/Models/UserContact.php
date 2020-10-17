<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;
use Dusterio\LumenPassport\LumenPassport;

class UserContact extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table ='tm_user_contact';
    protected $fillable = [
        'row_id',
        'fk_useruuid',
        'address_type',
        'address_type_txt',
        'addr_no',
        'addr_moo',
        'addr_building_village',
        'addr_soi',
        'addr_thanon_road',
        'addr_tambonid',
        'addr_tambon_name',
        'addr_ampid',
        'addr_amphur_name',
        'addr_proid',
        'addr_province_name',
        'telephone',
        'faxno',
        'mobilephone',
        'email',
        'active_flag',
        'created_by',
        'change_by'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password',
    // ];
}
