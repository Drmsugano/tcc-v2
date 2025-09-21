<?php
namespace App\Http\Controllers\Controle\Funcionario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class FuncionarioController extends Controller
{
    public function index()
    {
        return view ('Controle.Funcionario.index');
    }

}