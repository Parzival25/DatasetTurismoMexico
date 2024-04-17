<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atomo;

class DatasetController extends Controller
{
    function getlist(){
        // $atomos = DB::table('atomos')
		// 				 ->get();
        $atomos = Atomo::get();
        return $atomos;
    }
}
