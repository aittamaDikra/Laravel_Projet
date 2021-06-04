<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classs;

class rechercheController extends Controller
{
    function show(){
        $data = Classs::all();
        return view('Classe',['classes'=>$data]);
    }
}
