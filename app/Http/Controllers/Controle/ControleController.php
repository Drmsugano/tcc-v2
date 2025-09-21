<?php
namespace App\Http\Controllers\Controle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ControleController extends Controller
{
    public function index()
    {
        return view ('Controle.index');
    }

}