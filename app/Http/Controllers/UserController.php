<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Repository\UserRegisterRepository;
use App\Repository\UserLoginRepository;

class UserController extends Controller
{
    use Helpers;
    protected $regRepo;
    protected $logRepo;

    public function __construct(UserRegisterRepository $regRepo, UserLoginRepository $logRepo) {
        $this->regRepo = $regRepo;
        $this->logRepo = $logRepo;
    }

    #region Public Methods
    public function login(Request $request) {
        return $this->logRepo->validate($request);
    }

    public function register(Request $request) {
        // custom validation (temporary)
        if($this->regRepo->username_exists($request['account']))
            return $this->regRepo->error(
                'The given data was invalid.',
                ['account.username' => 'ชื่อผู้ใช้งานนี้มีอยู่แล้ว'],
                401);

        if($this->regRepo->citizenid_exists($request['userinfo']))
            return $this->regRepo->error(
                'The given data was invalid.',
                ['userinfo.citizenid' => 'เลขบัตรประชนนี้มีอยู่แล้ว'],
                401);

        // dingo full validation
        $this->validate($acc, $this->regRepo->validate());

        return $this->regRepo->create($request);
    }

    public function fileupload(Request $request) {
        return $this->regRepo->fileupload($request);
    }
    #endregion
}
