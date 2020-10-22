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
            return $this->error(
                'The given data was invalid.',
                ['username' => 'ชื่อผู้ใช้งานไม่ถูกต้อง'],
                401);
        else {
            $password = UserPassword::where('fk_useruuid', $login_user->useruuid)->first();
            if(!Hash::check($input['password'], $password->hash_pwd))
                return $this->error(
                    'The given data was invalid.',
                    ['password' => 'รหัสผ่านไม่ถูกต้อง'],
                    401);
        }

        return $this->success($login_user);
    }
    #endregion

    #region Validation Message
    private function success($data = '')
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'status_code' => 200
        ], 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    public function error($message, $errors, $statusCode)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
            'status_code' => $statusCode
        ], $statusCode)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
    #endregion
    #endregion
}