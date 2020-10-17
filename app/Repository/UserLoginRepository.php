<?php

namespace App\Repository;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\UserPassword;

class UserLoginRepository 
{
    #region Public Methods
    #region Validation
    public function validate($input) {
        $login_user = User::where('user_name', $input['user_name'])->first();
        if(!$login_user) {
            $res['success'] = false;
            $res['status_code'] = 401;
            $res['message'] = 'Your username incorrect';
            return response()->json($res, 401);
        }
        else {
            $password = UserPassword::where('fk_useruuid', $login_user->useruuid)->first();
            if(!Hash::check($input['password'], $password->hash_pwd)){
                $res['success'] = false;
                $res['status_code'] = 401;
                $res['message'] = 'Your password incorrect';
                return response()->json($res, 401);
            }
        }

        $res['success'] = true;
        $res['status_code'] = 200;
        $res['message'] = 'successful';
        $res['user'] = $login_user;
        return response()->json($res, 200);
    }
    #endregion
    #endregion
}