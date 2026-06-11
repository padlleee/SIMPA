<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AnakAsuh;
use App\Models\PengurusNonAktif;

class InfoController extends Controller
{
    public function index()
    {
        $alumni = AnakAsuh::alumni()->get();
        $pengurusNonAktif = PengurusNonAktif::all();
        
        return view('info', compact('alumni', 'pengurusNonAktif'));
    }
}
