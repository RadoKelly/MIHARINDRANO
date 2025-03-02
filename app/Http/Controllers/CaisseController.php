<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class CaisseController extends Controller
{
    public function index(Site $site)
    {
        return view('caisse.index',['site'=>$site]);
    }
}
