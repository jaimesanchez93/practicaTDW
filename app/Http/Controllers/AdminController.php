<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;


class AdminController extends Controller
{
    //

    

    public function index(){
        return view('admin/inicioAdmin');
    }

    public function listado(){
        return view('admin/listadoUsuarios');
    }
}
