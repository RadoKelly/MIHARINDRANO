<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
class FactureController extends Controller
{
    public function index(Site $site)
    {
        return view('facture.index',['site'=>$site]);
    }
}
