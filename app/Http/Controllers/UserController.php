<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Transformer\UserTransformer;

class UserController extends Controller
{
    use Helpers;

    protected $userRepository;
    protected $userTransformer;

    public function __construct(UserRepository $userRepository, UserTransformer $userTransformer) {
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
    }

    #region Public Methods
    #region Gets
    public function get() {
        ////backup fron passport
        //$user = $this->userRepository->getAll();
        //return $this->response->item($user, new UserTransformer());

        return response()->json($this->userRepository->getAll());
    }

    public function getBtId() {
        return response()->json($this->userRepository->getById($id));
    }
    #endregion

    #region Register
    public function getidentity() {
        return response()->json($this->success(sha1(time())));
    }

    public function register(Request $request) {
        $obj = null;

        $step = $request->input('regist_step');
        switch($step) {
            case "1":
                $obj = $this->validate($request, $this->userRepository->Validate_Step_1());
                break;
            case "2":
                $obj = $this->validate($request, $this->userRepository->Validate_Step_2());
                break;
            case "3":
                $obj = $this->validate($request, $this->userRepository->Validate_Step_3());
                break;
            case "4":
                $obj = $this->validate($request, $this->userRepository->Validate_Step_4());
                break;
            case "5":
                $obj = $this->validate($request, $this->userRepository->Validate_Step_5());
                break;
            case "6":
                $obj = $this->validate($request, $this->userRepository->Validate_Step_6());
                break;
            default:
        }

        return response()->json($this->success($obj));
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
    private function success($obj) {
        // inject callback parameters
        $reponse['message'] = "sucess";
        $reponse['status_code'] = 200;
        $reponse['response'] = $obj;

        return $reponse;
    } 
    #endregion
    #endregion
}
