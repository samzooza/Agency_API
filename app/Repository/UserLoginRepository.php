<?php

namespace App\Repository;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserPassword;

class UserLoginRepository 
{
    #region Public Methods
    public function validate($input) {
        $login_user = User::where('user_name', $input['user_name'])->first();
        if(!$login_user)
            return $this->error('Your username incorrect');
        else {
            $password = UserPassword::where('fk_useruuid', $login_user->useruuid)->first();
            if(!Hash::check($input['password'], $password->hash_pwd))
                return $this->error('Your password incorrect');
        }

        return $this->success($login_user);
    }
    #endregion

    #region Private Methods
    #region Helper
    private function success($login_user) {
        $res['success'] = true;
        $res['status_code'] = 200;
        $res['message'] = 'successful';
        $res['user'] = $login_user;
        return response()->json($res, 200);
    }

    private function error($message) {
        $res['success'] = false;
        $res['status_code'] = 401;
        $res['message'] = $message;
        return response()->json($res, 401);
    }
    #endregion
    #endregion
}