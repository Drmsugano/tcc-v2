<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
class AdminController extends Controller
{
    public function index(Request $request)
    {
        return view("Admin.index");
    }
}