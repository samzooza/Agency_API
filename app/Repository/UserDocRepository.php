<?php

namespace App\Repository;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\UserDoc;

class UserDocRepository
{
    #region Public Methods
    #region Temp Writer
    public function tempwrite($filetype, $request) {
        $filename = $request["filename"];
        $content = $request["content"];
        $extension = $request["extension"];
        $systemname = Str::uuid()->toString().'.'.$extension;

        switch($filetype) {
            case 'profile':
                Storage::disk('temp_profile')->put($systemname, $content);
                break;
            case 'idcard':
                Storage::disk('temp_id_card')->put($systemname, $content);
                break;
            case 'houseregistration':
                Storage::disk('temp_house_registration')->put($systemname, $content);
                break;
            case 'license':
                Storage::disk('temp_license')->put($systemname, $content);
                break;
            case 'bookbank':
                Storage::disk('temp_bookbank')->put($systemname, $content);
                break;
            default:
                break;
        }
        
        return $this->success($filename, $systemname);
    }
    #endregion
    #endregion

    #region Private Methods
    #region Helper
    private function success($filename, $systemname) {
        $res['success'] = true;
        $res['status_code'] = 201;
        $res['message'] = 'successful';
        $res['filename'] = $filename;
        $res['systemname'] = $systemname;
        return response()->json($res, 201);
    }
    #endregion
    #endregion
}