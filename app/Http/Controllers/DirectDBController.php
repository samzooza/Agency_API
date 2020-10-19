<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\DirectDBRepository;

class DirectDBController extends Controller
{
    protected $dbRepo;

    public function __construct(DirectDBRepository $dbRepo) {
        $this->dbRepo = $dbRepo;
    }

    public function getoccupation() {
        return $this->dbRepo->getoccupation();
    }
}