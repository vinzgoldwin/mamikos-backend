<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kost;

class KostController extends Controller
{

    public function show($id)
    {
        return Kost::where('kost_id', $id)->first();
    }
}
