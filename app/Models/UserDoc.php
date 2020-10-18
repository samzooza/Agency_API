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

class UserDoc extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table ='tm_user_register_doc_xref';
    protected $fillable = [
        'row_id',
        'fk_useruuid',
        'docu_type_code',
        'docu_type_name',
        'filepath',
        'filename',
        'filessize',
        'filetype',
        'created_at',
        'change_by'
    ];
}