<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Repository\UserRegisterRepository;

class UserRegisterController extends Controller
{
    use Helpers;
    protected $regRepo;

    public function __construct(UserRegisterRepository $regRepo) {
        $this->regRepo = $regRepo;
    }

    #region Public Methods
    public function register(Request $request) {
        $response = $this->validate($request, $this->regRepo->validate());
        return response()->json(
            $this->success($response)
        );
    }
    #endregion

    #region Create/Update/Delete
    public function create(Request $request) {
        return response()->json($this->userRepository->create($request), 201);
    }

    public function update($id, Request $request) {
        return response()->json($this->userRepository->update($id, $request), 200);
    }

    public function delete($id) {
        $this->userRepository->delete($id);
        return response('Deleted successfully', 200);
    }
    #endregion

    #region Helpers
    private function success($response) {
        // wrapper callback parameters
        $wrapper['message'] = "success";
        $wrapper['status_code'] = 200;
        //$wrapper['response'] = $response;

        return $wrapper;
    } 
    #endregion
    #endregion
}
