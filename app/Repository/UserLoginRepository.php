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
            return $this->error('Your username incorrect', 401);
        else {
            $password = UserPassword::where('fk_useruuid', $login_user->useruuid)->first();
            if(!Hash::check($input['password'], $password->hash_pwd))
                return $this->error('Your password incorrect', 401);
        }

        return $this->success($login_user);
    }
    #endregion

    #region Validation Message
    public function success($ret = '')
    {
        return response()->json(['status' => 'success', 'data' => $ret], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    public function error($message = 'Bad request', $statusCode = 200)
    {
        return response()->json(['status' => 'error', 'error' => $message], $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
    #endregion
    #endregion
}