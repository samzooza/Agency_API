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

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table ='tm_user';
    protected $fillable = [
        'row_id',
        'useruuid',
        'user_name',
        'email',
        'display_user_name',
        'picture_profile_url',
        'title_code_th',
        'title_name_th',
        'first_name_th',
        'last_name_th',
        'title_code_int',
        'title_name_int',
        'first_name_int',
        'last_name_int',
        'birth_date_dt',
        'birth_date_text',
        'aged',
        'gender_text',
        'religion_code',
        'religion_text',
        'citizen_id',
        'citizen_id_issuedate_dt',
        'citizen_id_issuedate_text',
        'tax_id',
        'user_note',
        'admin_flag',
        'active_flag',
        'receive_noti_flag',
        'last_login_ts',
        'created_by',
        'change_by'
    ];
}
