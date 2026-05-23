<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Kontrak;

class ProyekController extends Controller
{
    public function index()
    {
        $proyekList = Proyek::with('kontrak')->get();
        return view('proyek.index', compact('proyekList'));
    }

    public function create()
    {

        $kontrakList = Kontrak::doesntHave('proyek')->get();
        return view('proyek.create', compact('kontrakList'));
    }

    public function store(Request $request)
    {
        Proyek::create($request->all());
        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil ditambahkan lek!');
    }
}