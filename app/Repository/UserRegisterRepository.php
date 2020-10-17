<?php

namespace App\Repository;

use App\Models\UserRegister;

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
            'user_info.first_name_th' => 'required|max:100',
            'user_info.last_name_th' => 'required|max:100',
            'user_info.title_code_int' => 'max:20',
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
            // doc_adress
            'doc_adress.address_type' => 'required|numeric',
            'doc_adress.address_type_txt' => 'required|max:100',
            'doc_adress.addr_no' => 'max:100',
            'doc_adress.addr_moo' => 'max:100',
            'doc_adress.addr_building_village' => 'max:100',
            'doc_adress.addr_soi' => 'max:100',
            'doc_adress.addr_thanon_road' => 'max:100',
            'doc_adress.addr_tambonid' => 'numeric',
            'doc_adress.addr_tambon_name' => 'max:50',
            'doc_adress.addr_ampid' => 'numeric',
            'doc_adress.addr_amphur_name' => 'max:50',
            'doc_adress.addr_proid' => 'max:5',
            'doc_adress.addr_province_name' => 'max:20',
            'doc_adress.mobilephone' => 'max:50',
            'doc_adress.telephone' => 'max:50',
            'doc_adress.faxno' => 'max:50',
            'doc_adress.email' => 'email|max:100',
            'doc_adress.active_flag' => 'numeric',
            //other_info
            'other_info.occupation_code' => 'numeric',
            'other_info.occupation_name' => 'max:100',
            'other_info.targetgroup_code' => 'max:50',
            'other_info.targetgroup_text' => 'max:100'
        ];
    }
    #endregion

    #region Create/Update/Delete
    public function create($input) {
        //$user->password = Hash::make($input['password']);
        $user = new UserRegister();
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
        $user = UserRegister::findOrFail($id);
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
        $user = UserRegister::findOrFail($id);
        $user->delete();
    }
    #endregion
    #endregion
}