<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (session("jwt_token") !== null) {
            return view("home.index");
        }
        return redirect()->route('login')->withErrors(['msg' => 'Usuário Não Autenticado'])->withInput();
    }
}
