<?php

namespace App\Repository;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    #region Create/Update/Delete
    public function create($input) {
        $uuid32 = Str::uuid()->toString();
        $uuid16 = substr(str_replace("-", "", $uuid32), 0, 16);

        // user
        $account = $input['account'];
        $user_info = $input['user_info'];
        $this->create_user($account, $user_info, $uuid16);

        // address
        $contact_address = $input['contact_address'];
        $this->create_contact($contact_address, $uuid16);
        $doc_adress = $input['doc_address'];
        $this->create_contact($doc_adress, $uuid16);

        // other
        $other_info = $input['other_info'];
        $this->create_other($other_info, $uuid16);
    }
    #endregion
    #endregion

    #region Private Methods
    private function create_user($account, $user_info, $uuid) {
        DB::table('tm_user')->insert([
            'useruuid' => $uuid,
            'user_name' => $account['user_name'],
            'email' => $account['email'],
            'display_user_name' => $user_info['title_name_th'].$user_info['first_name_th'].' '.$user_info['last_name_th'],
            //'picture_profile_url' => $user_info['picture_profile_url'],
            'title_code_th' => $user_info['title_code_th'],
            'title_name_th' => $user_info['title_name_th'],
            'first_name_th' => $user_info['first_name_th'],
            'last_name_th' => $user_info['last_name_th'],
            'title_code_int' => $user_info['title_code_int'],
            'title_name_int' => $user_info['title_name_int'],
            'first_name_int' => $user_info['first_name_int'],
            'last_name_int' => $user_info['last_name_int'],
            'birth_date_dt' => $user_info['birth_date_dt'],
            'birth_date_text' => $user_info['birth_date_text'],
            'aged' => $user_info['aged'],
            'gender_text' => $user_info['gender_text'],
            'religion_code' => $user_info['religion_code'],
            'religion_text' => $user_info['religion_text'],
            'citizen_id' => $user_info['citizen_id'],
            'citizen_id_issuedate_dt' => $user_info['citizen_id_issuedate_dt'],
            'citizen_id_issuedate_text' => $user_info['citizen_id_issuedate_text'],
            'tax_id' => $user_info['tax_id'],
            //'user_note' => $user_info['user_note'],
            'admin_flag' => 0,
            'active_flag' => 1,
            'receive_noti_flag' => 0,
            'created_by' => 'admin'
        ]);
        
        DB::table('tm_user_passwd')->insert([
            'fk_useruuid' => $uuid,
            'hash_pwd' => Hash::make($account['password']),
            'active_flag' => 1,
            'created_by' => 'admin'
        ]);
    }

    private function create_contact($address, $uuid) {
        DB::table('tm_user_contact')->insert([
            'fk_useruuid' => $uuid,
            'address_type' => $address['address_type'],
            'address_type_txt' => $address['address_type_txt'],
            'addr_no' => $address['addr_no'],
            'addr_moo' => $address['addr_moo'],
            'addr_building_village' => $address['addr_building_village'],
            'addr_soi' => $address['addr_soi'],
            'addr_thanon_road' => $address['addr_thanon_road'],
            'addr_tambonid' => $address['addr_tambonid'],
            'addr_tambon_name' => $address['addr_tambon_name'],
            'addr_ampid' => $address['addr_ampid'],
            'addr_amphur_name' => $address['addr_amphur_name'],
            'addr_proid' => $address['addr_proid'],
            'addr_province_name' => $address['addr_province_name'],
            'telephone' => $address['telephone'],
            'faxno' => $address['faxno'],
            'mobilephone' => $address['mobilephone'],
            'email' => $address['email'],
            'active_flag' => 1,
            'created_by' => 'admin'
        ]);
    }

    private function create_other($other, $uuid) {
        DB::table('tm_user_otherinfo')->insert([
            'fk_useruuid' => $uuid,
            'occupation_code' => $other['occupation_code'],
            'occupation_name' => $other['occupation_name'],
            'targetgroup_code' => $other['targetgroup_code'],
            'targetgroup_text' => $other['targetgroup_text'],
            'active_flag' => 1,
            'created_by' => 'admin'
        ]);
    }
    #endregion
}