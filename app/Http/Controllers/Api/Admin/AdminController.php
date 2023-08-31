<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function isAdmin() : bool {
        if(auth()->user()->role == "admin")
            return true;
        return false;
    }



    
}
