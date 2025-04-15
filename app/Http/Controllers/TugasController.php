<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Kategori;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allTugas = Tugas::all();
        $kategori = Kategori::all(); 
        return view("tugas.index", compact("allTugas","kategori"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view("tugas.create", compact("kategori"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "judul_tugas" => "required|max:100",
            "waktu_mulai" => "required|date_format:Y-m-d\TH:i",
            "waktu_selesai" => "required|date_format:Y-m-d\TH:i",
            "id_kategori" => "required",
            "catatan" => "required",
            "status_tugas" => "required",
        ]);

        Tugas::create($validatedData);

        return redirect()->route("tugas.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Tugas $tugas)
    {
        return view("tugas.show", compact("tugas"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tugas $tugas)
    {
        $kategori = Kategori::all();
        return view("tugas.edit", compact("kategori", "tugas"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tugas $tugas)
    {
        $validatedData = $request->validate([
            "judul_tugas" => "required|max:100",
            "waktu_mulai" => "required|date_format:Y-m-d\TH:i",
            "waktu_selesai" => "required|date_format:Y-m-d\TH:i",
            'id_kategori' => "required",
            "catatan" => "required",
            "status_tugas" => 'required'
        ]);

        $tugas->update($validatedData);

        return redirect()->route("tugas.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();

        return redirect()->route("tugas.index");
    }
}