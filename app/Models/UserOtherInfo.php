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

class UserOtherInfo extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table ='tm_user_otherinfo';
    protected $fillable = [
        'row_id',
        'fk_useruuid',
        'occupation_code',
        'occupation_name',
        'targetgroup_code',
        'targetgroup_text',
        'active_flag',
        'created_by',
        'change_by'
    ];
}
