<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Obra;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
class AdminController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Usuario::where("EMPRESA_ID",$request->user()->EMPRESA_ID)->where('IS_DELETED',false)->count();
        $obras = Obra::where('EMPRESA_ID',$request->user()->EMPRESA_ID)->where('FINALIZADO',false)->count();
        return view("Admin.index",compact("usuario",'obras'));
    }
}