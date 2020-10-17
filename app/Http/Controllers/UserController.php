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
        $response = $this->regRepo->create($request);

        $res['message'] = "success";
        $res['status_code'] = 201;
        return response()->json($res, 201);
    }
    #endregion

    #region Helpers
    private function wrapper($message, $status) {
        // wrapper callback parameters
        $wrap['message'] = $message;
        $wrap['status_code'] = $status;

        return response()->json($wrap, $status);
    } 
    #endregion
    #endregion
}
