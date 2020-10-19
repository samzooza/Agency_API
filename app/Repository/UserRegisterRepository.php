<?php

namespace App\Repository;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserPassword;
use App\Models\UserContact;
use App\Models\UserOtherInfo;
use App\Models\UserOtherInfo_Targetgroup;

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
            'userinfo.titlecodeth' => 'required|max:20',
            'userinfo.titlenameth' => 'required|max:100',
            'userinfo.firstnameth' => 'required|max:100',
            'userinfo.lastnameth' => 'required|max:100',
            'userinfo.titlecodeint' => 'max:20',
            'userinfo.titlenameth' => 'max:100',
            'userinfo.firstnameint' => 'max:100',
            'userinfo.lastnameint' => 'max:100',
            'userinfo.birthdatedt' => 'date',
            'userinfo.birthdatetext' => 'max:8',
            'userinfo.aged' => 'numeric',
            'userinfo.gendertext' => 'required|max:50',
            'userinfo.religioncode' => 'max:20',
            'userinfo.religiontext' => 'max:20',
            'userinfo.citizenid' => 'required|max:50',
            'userinfo.citizenidissuedatedt' => 'required|date',
            'userinfo.citizenidissuedatetext' => 'required|max:8',
            'userinfo.taxid' => 'max:50',
            // contact_address
            'contactaddress.addresstype' => 'required|numeric',
            'contactaddress.addresstypetxt' => 'required|max:100',
            'contactaddress.addrno' => 'max:100',
            'contactaddress.addrmoo' => 'max:100',
            'contactaddress.addrbuildingvillage' => 'max:100',
            'contactaddress.addrsoi' => 'max:100',
            'contactaddress.addrthanonroad' => 'max:100',
            'contactaddress.addrtambonid' => 'numeric',
            'contactaddress.addrtambonname' => 'max:50',
            'contactaddress.addrampid' => 'numeric',
            'contactaddress.addramphurname' => 'max:50',
            'contactaddress.addrproid' => 'max:5',
            'contactaddress.addrprovincename' => 'max:20',
            'contactaddress.addrzipcode' => 'min:5|max:5|regex:/[0-9]{5}/',
            'contactaddress.mobilephone' => 'min:9|max:10|regex:/^0\d\d?[0-9]{3}[0-9]{4}/',
            'contactaddress.telephone' => 'min:9|max:10|regex:/^0\d\d?[0-9]{3}[0-9]{4}/',
            'contactaddress.faxno' => 'min:9|max:9|regex:/^0\d[0-9]{3}[0-9]{4}/',
            'contactaddress.email' => 'email|max:100',
            'contactaddress.activeflag' => 'numeric',
            // doc_address
            'docaddress.addresstype' => 'required|numeric',
            'docaddress.addresstypetxt' => 'required|max:100',
            'docaddress.addrno' => 'max:100',
            'docaddress.addrmoo' => 'max:100',
            'docaddress.addrbuildingvillage' => 'max:100',
            'docaddress.addrsoi' => 'max:100',
            'docaddress.addrthanon_road' => 'max:100',
            'docaddress.addrtambonid' => 'numeric',
            'docaddress.addrtambon_name' => 'max:50',
            'docaddress.addrampid' => 'numeric',
            'docaddress.addramphur_name' => 'max:50',
            'docaddress.addrproid' => 'max:5',
            'docaddress.addrprovince_name' => 'max:20',
            'docaddress.addrzipcode' => 'min:5|max:5|regex:/[0-9]{5}/',
            'docaddress.mobilephone' => 'min:9|max:10|regex:/^0\d\d?[0-9]{3}[0-9]{4}/',
            'docaddress.telephone' => 'min:9|max:10|regex:/^0\d\d?[0-9]{3}[0-9]{4}/',
            'docaddress.faxno' => 'min:9|max:9|regex:/^0\d[0-9]{3}[0-9]{4}/',
            'docaddress.email' => 'email|max:100',
            'docaddress.activeflag' => 'numeric',
            //other_info
            'otherinfo.occupationcode' => 'numeric',
            'otherinfo.occupationname' => 'max:100'
        ];
    }

    public function exists($account){
        return User::where('user_name', '=', $account['username'])->get()->count();
    }

    public function validatefileupload() {
        return [
            'category' => 'required',
            'filename' => 'required',
            'content' => 'required'
        ];
    }

    public function error($message) {
        $res['success'] = false;
        $res['status_code'] = 401;
        $res['errors'] = $message;
        return response()->json($res, 401);
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
        $this->create_contact($contact_address, $uuid16);
        $doc_adress = $input['docaddress'];
        $this->create_contact($doc_adress, $uuid16);

        // extract other
        $other_info = $input['otherinfo'];
        $this->create_otherinfo($other_info, $uuid16);

        //// extract fileuploads
        //$fileuploads = $input['fileuploads'];
        //$this->create_fileupload($fileuploads, $uuid16);

        return $this->success();
    }
    #endregion
    
    #region Temp File Writer (action upload from UI)
    public function tempwrite($request) {
        $category = $request["category"];
        $filename = $request["filename"];
        $content = $request["content"];

        // disk name in app\Config\filesystems
        $tempdisk = 'temp_'.$category; 
        // save file into app\storage\temp\*
        Storage::disk($tempdisk)->put($filename, $content);

        return $this->success();
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
        $user->display_user_name = $info['titlenameth'].$info['firstnameth'].' '.$info['lastnameth'];
        //'picture_profile_url = $info['pictureprofileurl'];
        $user->title_code_th = $info['titlecodeth'];
        $user->title_name_th = $info['titlenameth'];
        $user->first_name_th = $info['firstnameth'];
        $user->last_name_th = $info['lastnameth'];
        $user->title_code_int = $info['titlecodeint'];
        $user->title_name_int = $info['titlenameint'];
        $user->first_name_int = $info['firstnameint'];
        $user->last_name_int = $info['lastnameint'];
        $user->birth_date_dt = $info['birthdatedt'];
        $user->birth_date_text = $info['birthdatetext'];
        $user->aged = $info['aged'];
        $user->gender_text = $info['gendertext'];
        $user->religion_code = $info['religioncode'];
        $user->religion_text = $info['religiontext'];
        $user->citizen_id = $info['citizenid'];
        $user->citizen_id_issuedate_dt = $info['citizenidissuedatedt'];
        $user->citizen_id_issuedate_text = $info['citizenidissuedatetext'];
        $user->tax_id = $info['taxid'];
        //'user_note' = $info['usernote'];
        $user->admin_flag = 0;
        $user->active_flag = 1;
        $user->receive_noti_flag = 0;
        $user->created_by = 'Webagency';
        $user->save();

        $userPass = new UserPassword();
        $userPass->fk_useruuid = $uuid;
        $userPass->hash_pwd = Hash::make($account['password']);
        $userPass->active_flag = 1;
        $userPass->created_by = 'Webagency';
        $userPass->save();
    }

    private function create_contact($address, $uuid) {
        $userCont = new UserContact();
        $userCont->fk_useruuid = $uuid;
        $userCont->address_type = $address['addresstype'];
        $userCont->address_type_txt = $address['addresstypetxt'];
        $userCont->addr_no = $address['addrno'];
        $userCont->addr_moo = $address['addrmoo'];
        $userCont->addr_building_village = $address['addrbuildingvillage'];
        $userCont->addr_soi = $address['addrsoi'];
        $userCont->addr_thanon_road = $address['addrthanonroad'];
        $userCont->addr_tambonid = $address['addrtambonid'];
        $userCont->addr_tambon_name = $address['addrtambonname'];
        $userCont->addr_ampid = $address['addrampid'];
        $userCont->addr_amphur_name = $address['addramphurname'];
        $userCont->addr_proid = $address['addrproid'];
        $userCont->addr_zipcode = $address['addrzipcode'];
        $userCont->telephone = $address['telephone'];
        $userCont->faxno = $address['faxno'];
        $userCont->mobilephone = $address['mobilephone'];
        $userCont->email = $address['email'];
        $userCont->active_flag = 1;
        $userCont->created_by = 'Webagency';
        $userCont->save();
    }

    private function create_otherinfo($otherinfo, $uuid) {
        $userOther = new UserOtherInfo();
        $userOther->fk_useruuid = $uuid;
        $userOther->occupation_code = $otherinfo['occupationcode'];
        $userOther->occupation_name = $otherinfo['occupationname'];
        $userOther->active_flag = 1;
        $userOther->created_by = 'Webagency';
        $userOther->save();

        $targets = $otherinfo['targetgroup'];
        foreach ($targets as $target) {
            $usertarget = new UserOtherInfo_Targetgroup();
            $usertarget->fk_useruuid = $uuid;
            $usertarget->targetgroup_code = $target['value'];
            $usertarget->save();
        }
    }

    private function create_fileupload($files, $uuid) {
        foreach ($files as $file) {
            $category = $file["category"];
            $filename = $file["filename"];
            $filesystemname = $this->encrypt($filename);

            // disk name in app\Config\filesystems
            $tempdisk = 'temp_'.$category;
            // get file content (app\storage\temp\*)
            $content = Storage::disk($tempdisk)->get($filename);
            
            // disk name in app\Config\filesystems
            $registereddisk = 'registered_'.$category;
            // create file in 'registered' folder
            Storage::disk($registereddisk)->put($filesystemname, $content);

            // delete file in 'temp' folder
            Storage::disk($tempdisk)->delete($filename, $content);
        }
    }
    
    #endregion
    
    #region Helper
    private function encrypt($filename) {
        $extension = end(explode(".", $filename));
        return Str::uuid()->toString().'.'.$extension;
    }

    private function success() {
        $res['success'] = true;
        $res['status_code'] = 201;
        $res['message'] = 'successful';
        return response()->json($res, 201);
    }
    #endregion
    #endregion
}