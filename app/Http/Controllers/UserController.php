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
        $exists = $this->regRepo->exists($request['account']);
        if($exists)
            return $this->regRepo->error("ชื่อผู้ใช้งานนี้มีอยู่แล้ว", 401);

        // validate
        $response = $this->validate($request, $this->regRepo->validate());

        return $this->regRepo->create($request);
    }

    public function fileupload(Request $request) {
        return $this->regRepo->fileupload($request);
    }
    #endregion
}
