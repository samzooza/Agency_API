<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\UserDocRepository;

class FileController extends Controller
{
    protected $userDocRepo;

    public function __construct(UserDocRepository $userDocRepo) {
        $this->userDocRepo = $userDocRepo;
    }

    public function writeprofile(Request $request) {
        return $this->userDocRepo->tempwrite('profile', $request);
    }

    public function writeidcard(Request $request) {
        return $this->userDocRepo->tempwrite('idcard', $request);
    }

    public function writehouseregistration(Request $request) {
        return $this->userDocRepo->tempwrite('houseregistration', $request);
    }

    public function writelicense(Request $request) {
        return $this->userDocRepo->tempwrite('license', $request);
    }

    public function writebookbank(Request $request) {
        return $this->userDocRepo->tempwrite('bookbank', $request);
    }

    public function read() {
        $data = Storage::disk('temporary')->get('file.txt');
        var_dump($data);
    }
}