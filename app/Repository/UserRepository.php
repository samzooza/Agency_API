<?php

namespace App\Repository;

use App\Models\User;

class UserRepository 
{
    #region Public Methods
    #region Gets
    function getAll() {
        return User::all();
    }

    function getById($id) {
        return User::find($id);
    }
    #endregion

    #region Login

    #endregion
    
    #region Validation
    #region Step#1
    function Validate_Step_1() {
        return [
            'user_name' => 'required|max:100',
            'email' => 'required|email|max:255',
            'password' => 'required|max:100',
            'identity' => 'required'
        ];
    }
    #endregion

    #region Step#2
    function Validate_Step_2() {
        return [
            'title_code_th' => 'required|max:20',
            'first_name_th' => 'required|max:100',
            'last_name_th' => 'required|max:100',
            'title_code_int' => 'max:20',
            'first_name_int' => 'max:100',
            'last_name_int' => 'max:100',
            'birth_date_dt' => 'date',
            'birth_date_text' => 'max:8',
            'aged' => 'numeric',
            'gender_text' => 'required|max:50',
            'religion_code' => 'max:20',
            'religion_text' => 'max:20',
            'citizen_id' => 'required|max:50',
            'citizen_id_issuedate_dt' => 'required|date',
            'citizen_id_issuedate_text' => 'required|max:8',
            'tax_id' => 'max:50',
            'identity' => 'required'
        ];
    }
    #endregion

    #region Step#3
    function Validate_Step_3() {
        return [
            'address_type' => 'required|numeric',
            'address_type_txt' => 'required|max:100',
            'addr_no' => 'max:100',
            'addr_moo' => 'max:100',
            'addr_building_village' => 'max:100',
            'addr_soi' => 'max:100',
            'addr_thanon_road' => 'max:100',
            'addr_tambonid' => 'numeric',
            'addr_tambon_name' => 'max:50',
            'addr_ampid' => 'numeric',
            'addr_amphur_name' => 'max:50',
            'addr_proid' => 'max:5',
            'addr_province_name' => 'max:20',
            'mobilephone' => 'max:50',
            'telephone' => 'phone',
            'faxno' => 'max:50',
            'email' => 'email|max:100',
            'active_flag' => 'numeric',
            'identity' => 'required'
        ];
    }
    #endregion

    #region Step#4
    function Validate_Step_4() {
        return [
            'title' => '',
            'description' => '',
            'identity' => ''
        ];
    }
    #endregion

    #region Step#5
    function Validate_Step_5() {
        return [
            'occupation_code' => 'numeric',
            'occupation_name' => 'max:100',
            'targetgroup_code' => 'max:50',
            'targetgroup_text' => 'max:100',
            'identity' => 'required'
        ];
    }
    #endregion

    #region Step#6
    function Validate_Step_6($input) {
        return [
            'agree' => 'required|bool',
            'identity' => 'required'
        ];
    }
    #endregion
    #endregion

    #region Create/Update/Delete
    public function create($input) {
        //$user->password = Hash::make($input['password']);
        $user = new User();
        $user->useruuid = $input['useruuid'];
        $user->email = $input['email'];
        $user->display_user_name = $input['display_user_name'];
        $user->picture_profile_url = $input['picture_profile_url'];
        $user->title_code_th = $input['title_code_th'];
        $user->title_name_th = $input['title_name_th'];
        $user->first_name_th = $input['first_name_th'];
        $user->last_name_th = $input['last_name_th'];
        $user->title_code_int = $input['title_code_int'];
        $user->title_name_int = $input['title_name_int'];
        $user->first_name_int = $input['first_name_int'];
        $user->last_name_int = $input['last_name_int'];
        $user->birth_date_dt = $input['birth_date_dt'];
        $user->birth_date_text = $input['birth_date_text'];
        $user->aged = $input['aged'];
        $user->gender_text = $input['gender_text'];
        $user->religion_code = $input['religion_code'];
        $user->religion_text = $input['religion_text'];
        $user->citizen_id = $input['citizen_id'];
        $user->citizen_id_issuedate_dt = $input['citizen_id_issuedate_dt'];
        $user->citizen_id_issuedate_text = $input['citizen_id_issuedate_text'];
        $user->tax_id = $input['tax_id'];
        $user->user_note = $input['user_note'];
        $user->admin_flag = $input['admin_flag'];
        $user->active_flag = $input['active_flag'];
        $user->receive_noti_flag = $input['receive_noti_flag'];
        $user->last_login_ts = $input['last_login_ts'];
        $user->created_by = $input['created_by'];
        $user->save();
    }

    public function update($id, $input) {
        $user = User::findOrFail($id);
        $user->useruuid = $input['useruuid'];
        $user->email = $input['email'];
        $user->display_user_name = $input['display_user_name'];
        $user->picture_profile_url = $input['picture_profile_url'];
        $user->title_code_th = $input['title_code_th'];
        $user->title_name_th = $input['title_name_th'];
        $user->first_name_th = $input['first_name_th'];
        $user->last_name_th = $input['last_name_th'];
        $user->title_code_int = $input['title_code_int'];
        $user->title_name_int = $input['title_name_int'];
        $user->first_name_int = $input['first_name_int'];
        $user->last_name_int = $input['last_name_int'];
        $user->birth_date_dt = $input['birth_date_dt'];
        $user->birth_date_text = $input['birth_date_text'];
        $user->aged = $input['aged'];
        $user->gender_text = $input['gender_text'];
        $user->religion_code = $input['religion_code'];
        $user->religion_text = $input['religion_text'];
        $user->citizen_id = $input['citizen_id'];
        $user->citizen_id_issuedate_dt = $input['citizen_id_issuedate_dt'];
        $user->citizen_id_issuedate_text = $input['citizen_id_issuedate_text'];
        $user->tax_id = $input['tax_id'];
        $user->user_note = $input['user_note'];
        $user->admin_flag = $input['admin_flag'];
        $user->active_flag = $input['active_flag'];
        $user->receive_noti_flag = $input['receive_noti_flag'];
        $user->last_login_ts = $input['last_login_ts'];
        $user->change_by = $input['change_by'];
        $user->save();
    }

    public function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
    }
    #endregion
    #endregion
}