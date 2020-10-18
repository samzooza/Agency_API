<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\UserRegisterRepository;

class FileController extends Controller
{
    protected $regRepo;

    public function __construct(UserRegisterRepository $regRepo) {
        $this->regRepo = $regRepo;
    }

    public function fileupload(Request $request) {
        // validate
        $response = $this->validate($request, $this->regRepo->validatefileupload());

        return $this->regRepo->tempwrite($request);
    }

    public function read() {
        $data = Storage::disk('temporary')->get('file.txt');
        var_dump($data);
    }
}