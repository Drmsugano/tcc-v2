<?php
namespace App\Http\Controllers\Controle\Epi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class EpiController extends Controller
{
    public function index()
    {
        return view ('Controle.Epi.index');
    }

}