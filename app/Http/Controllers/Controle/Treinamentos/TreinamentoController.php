<?php
namespace App\Http\Controllers\Controle\Treinamentos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TreinamentoController extends Controller
{
    public function index()
    {
        return view ('Controle.Treinamentos.index');
    }

}