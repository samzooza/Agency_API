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
        // validate
        $response = $this->validate($request, $this->regRepo->validate());

        // create action
        return $this->regRepo->create($request);
    }
    #endregion
}
