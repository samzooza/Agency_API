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
        return $this->regRepo->fileupload($request);
    }
}