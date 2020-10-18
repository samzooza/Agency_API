<?php

namespace App\Repository;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserPassword;
use App\Models\UserContact;
use App\Models\UserOtherInfo;

class UserRegisterRepository 
{
    #region Public Methods
    #region Validation
    public function validate() {
        return [
            // account
            'account.user_name' => 'required|min:8|max:100',
            'account.email' => 'required|email|max:255',
            'account.password' => 'required|min:8|max:100',
            // user_info
            'user_info.title_code_th' => 'required|max:20',
            'user_info.title_name_th' => 'required|max:100',
            'user_info.first_name_th' => 'required|max:100',
            'user_info.last_name_th' => 'required|max:100',
            'user_info.title_code_int' => 'max:20',
            'user_info.title_name_th' => 'max:100',
            'user_info.first_name_int' => 'max:100',
            'user_info.last_name_int' => 'max:100',
            'user_info.birth_date_dt' => 'date',
            'user_info.birth_date_text' => 'max:8',
            'user_info.aged' => 'numeric',
            'user_info.gender_text' => 'required|max:50',
            'user_info.religion_code' => 'max:20',
            'user_info.religion_text' => 'max:20',
            'user_info.citizen_id' => 'required|max:50',
            'user_info.citizen_id_issuedate_dt' => 'required|date',
            'user_info.citizen_id_issuedate_text' => 'required|max:8',
            'user_info.tax_id' => 'max:50',
            // contact_address
            'contact_address.address_type' => 'required|numeric',
            'contact_address.address_type_txt' => 'required|max:100',
            'contact_address.addr_no' => 'max:100',
            'contact_address.addr_moo' => 'max:100',
            'contact_address.addr_building_village' => 'max:100',
            'contact_address.addr_soi' => 'max:100',
            'contact_address.addr_thanon_road' => 'max:100',
            'contact_address.addr_tambonid' => 'numeric',
            'contact_address.addr_tambon_name' => 'max:50',
            'contact_address.addr_ampid' => 'numeric',
            'contact_address.addr_amphur_name' => 'max:50',
            'contact_address.addr_proid' => 'max:5',
            'contact_address.addr_province_name' => 'max:20',
            'contact_address.mobilephone' => 'max:50',
            'contact_address.telephone' => 'max:50',
            'contact_address.faxno' => 'max:50',
            'contact_address.email' => 'email|max:100',
            'contact_address.active_flag' => 'numeric',
            // doc_address
            'doc_address.address_type' => 'required|numeric',
            'doc_address.address_type_txt' => 'required|max:100',
            'doc_address.addr_no' => 'max:100',
            'doc_address.addr_moo' => 'max:100',
            'doc_address.addr_building_village' => 'max:100',
            'doc_address.addr_soi' => 'max:100',
            'doc_address.addr_thanon_road' => 'max:100',
            'doc_address.addr_tambonid' => 'numeric',
            'doc_address.addr_tambon_name' => 'max:50',
            'doc_address.addr_ampid' => 'numeric',
            'doc_address.addr_amphur_name' => 'max:50',
            'doc_address.addr_proid' => 'max:5',
            'doc_address.addr_province_name' => 'max:20',
            'doc_address.mobilephone' => 'max:50',
            'doc_address.telephone' => 'max:50',
            'doc_address.faxno' => 'max:50',
            'doc_address.email' => 'email|max:100',
            'doc_address.active_flag' => 'numeric',
            //other_info
            'other_info.occupation_code' => 'numeric',
            'other_info.occupation_name' => 'max:100',
            'other_info.targetgroup_code' => 'max:50',
            'other_info.targetgroup_text' => 'max:100'
        ];
    }
    #endregion

    #region Create
    public function create($input) {
        $uuid32 = Str::uuid()->toString();
        $uuid16 = substr(str_replace("-", "", $uuid32), 0, 16);

        // extract user
        $account = $input['account'];
        $info = $input['user_info'];
        $this->create_user($account, $info, $uuid16);

        // extract address
        $contact_address = $input['contact_address'];
        $this->create_contact($contact_address, $uuid16);
        $doc_adress = $input['doc_address'];
        $this->create_contact($doc_adress, $uuid16);

        // extract other
        $other_info = $input['other_info'];
        $this->create_otherinfo($other_info, $uuid16);

        return $this->success();
    }
    #endregion
    #endregion

    #region Private Methods
    #region Process
    private function create_user($account, $info, $uuid) {
        $user = new User();
        $user->useruuid = $uuid;
        $user->user_name = $account['user_name'];
        $user->email = $account['email'];
        $user->display_user_name = $info['title_name_th'].$info['first_name_th'].' '.$info['last_name_th'];
        //'picture_profile_url = $info['picture_profile_url'];
        $user->title_code_th = $info['title_code_th'];
        $user->title_name_th = $info['title_name_th'];
        $user->first_name_th = $info['first_name_th'];
        $user->last_name_th = $info['last_name_th'];
        $user->title_code_int = $info['title_code_int'];
        $user->title_name_int = $info['title_name_int'];
        $user->first_name_int = $info['first_name_int'];
        $user->last_name_int = $info['last_name_int'];
        $user->birth_date_dt = $info['birth_date_dt'];
        $user->birth_date_text = $info['birth_date_text'];
        $user->aged = $info['aged'];
        $user->gender_text = $info['gender_text'];
        $user->religion_code = $info['religion_code'];
        $user->religion_text = $info['religion_text'];
        $user->citizen_id = $info['citizen_id'];
        $user->citizen_id_issuedate_dt = $info['citizen_id_issuedate_dt'];
        $user->citizen_id_issuedate_text = $info['citizen_id_issuedate_text'];
        $user->tax_id = $info['tax_id'];
        //'user_note' = $info['user_note'];
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
        $userCont->address_type = $address['address_type'];
        $userCont->address_type_txt = $address['address_type_txt'];
        $userCont->addr_no = $address['addr_no'];
        $userCont->addr_moo = $address['addr_moo'];
        $userCont->addr_building_village = $address['addr_building_village'];
        $userCont->addr_soi = $address['addr_soi'];
        $userCont->addr_thanon_road = $address['addr_thanon_road'];
        $userCont->addr_tambonid = $address['addr_tambonid'];
        $userCont->addr_tambon_name = $address['addr_tambon_name'];
        $userCont->addr_ampid = $address['addr_ampid'];
        $userCont->addr_amphur_name = $address['addr_amphur_name'];
        $userCont->addr_proid = $address['addr_proid'];
        $userCont->addr_province_name = $address['addr_province_name'];
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
        $userOther->occupation_code = $otherinfo['occupation_code'];
        $userOther->occupation_name = $otherinfo['occupation_name'];
        $userOther->targetgroup_code = $otherinfo['targetgroup_code'];
        $userOther->targetgroup_text = $otherinfo['targetgroup_text'];
        $userOther->active_flag = 1;
        $userOther->created_by = 'Webagency';
        $userOther->save();
    }
    #endregion
    
    #region Helper
    private function success() {
        $res['success'] = true;
        $res['status_code'] = 201;
        $res['message'] = 'successful';
        return response()->json($res, 201);
    }
    #endregion
    #endregion
}