<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DirectDBRepository 
{
    #region Public Methods
    public function getoccupation() {
        return DB::connection('mysql')
        ->select("SELECT occupation_code as value, occupation_name as text FROM tm_occupation");
    }

    public function gettargetgroup() {
        return DB::connection('mysql')
        ->select("SELECT targetgroup_code as value, targetgroup_text as text FROM tm_targetgroup");
    }
    #endregion
}