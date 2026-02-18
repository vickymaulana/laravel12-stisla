<?php

namespace App\Http\Controllers;

use App\Models\Hakakses;
use Illuminate\Http\Request;

class HakaksesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search = $request->get('search');
        if ($search) {
            $data['hakakses'] = Hakakses::where('id', 'like', "%{$search}%")->get();
        } else {
            $data['hakakses'] = Hakakses::all();
        }

        return view('layouts.hakakses.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Hakakses $hakakses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $hakakses = Hakakses::find($id);

        return view('layouts.hakakses.edit', compact('hakakses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hakakses $hakakses, $id)
    {
        //
        $hakakses = Hakakses::find($id);
        $hakakses->role = $request->role;
        $hakakses->save();

        return redirect()->route('hakakses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hakakses $hakakses)
    {
        //
        $hakakses->delete();
    }
}
