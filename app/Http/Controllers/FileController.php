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
        $response = null;
        $array = ["profile", "id_card", "house_registration", "license", "bookbank"];

        foreach($array as $file){
            if ($request->hasFile($file)) {
                $foo = (object) [$file => ""];
                $original_filename = $request->file($file)->getClientOriginalName();
                $destination_path = './filedrop/upload/'.$file;

                if ($request->file($file)->move($destination_path, $original_filename)) {
                    $foo->image = '/filedrop/upload/'.$file.'/'. $original_filename;
                    return $this->responseRequestSuccess($foo);
                } else {
                    return $this->responseRequestError('Cannot upload file');
                }
            }
        }
    }

    protected function responseRequestSuccess($ret)
    {
        return response()->json(['status' => 'success', 'data' => $ret], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    protected function responseRequestError($message = 'Bad request', $statusCode = 200)
    {
        return response()->json(['status' => 'error', 'error' => $message], $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}