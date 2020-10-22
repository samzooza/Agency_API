<?php

namespace App\Repository;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserPassword;
use App\Models\UserContact;
use App\Models\UserOtherInfo;
use App\Models\UserOtherInfo_Targetgroup;
use App\Models\UserRegisterDoc;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Finder\SplFileInfo;

class UserRegisterRepository 
{
    #region Public Methods
    #region Validation
    public function validate() {
        return [
            // account
            'account.username' => 'required|min:8|max:100',
            'account.email' => 'required|email|max:255',
            'account.password' => 'required|min:8|max:100',
            // user_info
            'userinfo.titlenameth' => 'required|max:100',
            'userinfo.firstnameth' => 'required|max:100',
            'userinfo.lastnameth' => 'required|max:100',
            'userinfo.titlenameth' => 'max:100',
            'userinfo.firstnameint' => 'max:100',
            'userinfo.lastnameint' => 'max:100',
            'userinfo.birthdatedt' => 'date',
            'userinfo.aged' => 'numeric',
            'userinfo.gendertext' => 'required|max:50',
            'userinfo.religiontext' => 'max:20',
            'userinfo.citizenid' => 'required|min:13|max:13',
            'userinfo.citizenidissuedatedt' => 'required|date',
            'userinfo.taxid' => 'max:50',
            'userinfo.activeflag' => 'numeric',
            // contact_address
            'contactaddress.addrno' => 'max:100',
            'contactaddress.addrmoo' => 'max:100',
            'contactaddress.addrbuildingvillage' => 'max:100',
            'contactaddress.addrsoi' => 'max:100',
            'contactaddress.addrthanonroad' => 'max:100',
            'contactaddress.addrtambonname' => 'max:50',
            'contactaddress.addramphurname' => 'max:50',
            'contactaddress.addrprovincename' => 'max:20',
            'contactaddress.addrzipcode' => 'min:5|max:5|regex:/[0-9]{5}/',
            'contactaddress.mobilephone' => 'min:9|max:10|regex:/^0\d\d?[0-9]{3}[0-9]{4}/',
            'contactaddress.telephone' => 'min:9|max:10|regex:/^0\d\d?[0-9]{3}[0-9]{4}/',
            'contactaddress.faxno' => 'min:9|max:9|regex:/^0\d[0-9]{3}[0-9]{4}/',
            'contactaddress.email' => 'email|max:100',
            'contactaddress.activeflag' => 'numeric',
            // doc_address
            'docaddress.addrno' => 'max:100',
            'docaddress.addrmoo' => 'max:100',
            'docaddress.addrbuildingvillage' => 'max:100',
            'docaddress.addrsoi' => 'max:100',
            'docaddress.addrthanon_road' => 'max:100',
            'docaddress.addrtambon_name' => 'max:50',
            'docaddress.addramphur_name' => 'max:50',
            'docaddress.addrprovince_name' => 'max:20',
            'docaddress.addrzipcode' => 'min:5|max:5|regex:/[0-9]{5}/',
            'docaddress.mobilephone' => 'min:9|max:10|regex:/^0\d\d?[0-9]{3}[0-9]{4}/',
            'docaddress.telephone' => 'min:9|max:10|regex:/^0\d\d?[0-9]{3}[0-9]{4}/',
            'docaddress.faxno' => 'min:9|max:9|regex:/^0\d[0-9]{3}[0-9]{4}/',
            'docaddress.email' => 'email|max:100',
            'docaddress.activeflag' => 'numeric',
            //other_info
            'otherinfo.occupationname' => 'max:100',
            'otherinfo.activeflag' => 'numeric'
        ];
    }

    public function username_exists($account){
        return User::where('user_name', '=', $account['username'])->get()->count();
    }

    public function citizenid_exists($userinfo){
        return User::where('citizen_id', '=', $userinfo['citizenid'])->get()->count();
    }
    #endregion

    #region File Upload
    public function fileupload($request) {
        $response = null;
        $array = [
            "profile_picture",
            "id_card",
            "house_registration",
            "license",
            "fixed_deposit",
            "bank_deposit",
            "office_location"
        ];

        foreach($array as $file){
            if ($request->hasFile($file)) {
                $foo = (object) [$file => ""];
                $original_filename = $request->file($file)->getClientOriginalName();
                $destination_path = './filedrop/'.$file;

                $filename_arr = explode('.', $original_filename);
                $file_ext = strtolower(end($filename_arr));
                $nanotime = (int) (microtime(true) * 1000000);
                $encryptname = strtoupper(substr($file, 0, 1)). '-' . "1" . '-' . $nanotime  . '.' . $file_ext;
                $filessize = $request->file($file)->getSize();

                if ($request->file($file)->move($destination_path, $encryptname)) {
                    $ret = new UserRegisterDoc();
                    $ret->docutypename = $file;
                    $ret->filepath = '/filedrop/'.$file;
                    $ret->filename = $encryptname;
                    $ret->filessize = $filessize;
                    $ret->filetype = $file_ext;
                    
                    return response()->json([
                        'status' => 'success',
                        'fileuploads' => $ret,
                        'status_code' => 200
                    ], 200)
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

                } else
                    return $this->error('Cannot upload file', '', 500);
            }
        }
    }
    #endregion

    #region Create
    public function create($input) {
        $uuid32 = Str::uuid()->toString();
        $uuid16 = substr(str_replace("-", "", $uuid32), 0, 16);

        // extract user
        $account = $input['account'];
        $info = $input['userinfo'];
        $this->create_user($account, $info, $uuid16);

        // extract address
        $contact_address = $input['contactaddress'];
        $this->create_contact(1, "ที่อยู่ติดต่อ", $contact_address, $uuid16);
        $doc_adress = $input['docaddress'];
        $this->create_contact(2, "ที่อยู่จัดส่งเอกสาร", $doc_adress, $uuid16);

        // extract other
        $other_info = $input['otherinfo'];
        $this->create_otherinfo($other_info, $uuid16);

        // extract fileuploads
        try{
            $fileuploads = $input['fileuploads'];
            $this->create_registerdoc($fileuploads, $uuid16);
        } catch (Exception $e) {}

        return $this->success("successful");
    }
    #endregion

    #region Validation Message
    private function success($data = '')
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'status_code' => 200
        ], 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    public function error($message, $errors, $statusCode)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
            'status_code' => $statusCode
        ], $statusCode)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
    #endregion
    #endregion

    #region Private Methods
    #region Process
    private function create_user($account, $info, $uuid) {
        $user = new User();
        $user->useruuid = $uuid;
        $user->user_name = $account['username'];
        $user->email = $account['email'];
        $user->display_user_name = $info['titlenameth'].$info['titlenameth'].$info['firstnameth'].' '.$info['lastnameth'];
        $user->title_name_th = $info['titlenameth'];
        $user->first_name_th = $info['firstnameth'];
        $user->last_name_th = $info['lastnameth'];
        $user->title_name_int = $info['titlenameint'];
        $user->first_name_int = $info['firstnameint'];
        $user->last_name_int = $info['lastnameint'];
        $user->birth_date_dt = $info['birthdatedt'];
        $user->aged = $info['aged'];
        $user->gender_text = $info['gendertext'];
        $user->religion_text = $info['religiontext'];
        $user->citizen_id = $info['citizenid'];
        $user->citizen_id_issuedate_dt = $info['citizenidissuedatedt'];
        $user->tax_id = $info['taxid'];
        $user->admin_flag = 0;
        $user->active_flag = $info['activeflag'];
        $user->receive_noti_flag = 0;
        $user->created_by = 'Webagency';
        $user->save();

        $userPass = new UserPassword();
        $userPass->fk_useruuid = $uuid;
        $userPass->hash_pwd = Hash::make($account['password']);
        $userPass->active_flag = $info['activeflag'];
        $userPass->created_by = 'Webagency';
        $userPass->save();
    }

    private function create_contact($ano, $atype, $address, $uuid) {
        $userCont = new UserContact();
        $userCont->fk_useruuid = $uuid;
        $userCont->address_type = $ano;
        $userCont->address_type_txt = $atype;
        $userCont->addr_no = $address['addrno'];
        $userCont->addr_moo = $address['addrmoo'];
        $userCont->addr_building_village = $address['addrbuildingvillage'];
        $userCont->addr_soi = $address['addrsoi'];
        $userCont->addr_thanon_road = $address['addrthanonroad'];
        $userCont->addr_tambon_name = $address['addrtambonname'];
        $userCont->addr_amphur_name = $address['addramphurname'];
        $userCont->addr_province_name = $address['addrprovincename'];
        $userCont->addr_zipcode = $address['addrzipcode'];
        $userCont->telephone = $address['telephone'];
        $userCont->faxno = $address['faxno'];
        $userCont->mobilephone = $address['mobilephone'];
        $userCont->email = $address['email'];
        $userCont->active_flag = $address['activeflag'];
        $userCont->created_by = 'Webagency';
        $userCont->save();
    }

    private function create_otherinfo($otherinfo, $uuid) {
        $userOther = new UserOtherInfo();
        $userOther->fk_useruuid = $uuid;
        $userOther->occupation_name = $otherinfo['occupationname'];
        $userOther->active_flag = $otherinfo['activeflag'];
        $userOther->created_by = 'Webagency';
        $userOther->save();

        $targets = $otherinfo['targetgroup'];
        foreach ($targets as $target) {
            $usertarget = new UserOtherInfo_Targetgroup();
            $usertarget->fk_useruuid = $uuid;
            $usertarget->targetgroup_text = $target;
            $usertarget->save();
        }

        if(isset($otherinfo['targetgroupcustom']) && $otherinfo['targetgroupcustom'] != "") {
            $custom = new UserOtherInfo_Targetgroup();
            $custom->fk_useruuid = $uuid;
            $custom->targetgroup_text = $otherinfo['targetgroupcustom'];
            $custom->save();
        }
    }

    private function create_registerdoc($regisfiles, $uuid) {
        foreach ($regisfiles as $regisfile) {
            $ret = new UserRegisterDoc();
            $ret->fk_useruuid = $uuid;
            $ret->docu_type_name = $regisfile["docutypename"];
            $ret->filepath = $regisfile["filepath"];
            $ret->filename = $regisfile["filename"];
            $ret->filessize = $regisfile["filessize"];
            $ret->filetype = $regisfile["filetype"];
            $ret->created_by = 'Webagency';
            $ret->save();
        }
    }
    #endregion
    #endregion
}