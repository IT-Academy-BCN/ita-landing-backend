<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\App;

class AppController extends Controller
{
    /**
     * Display a listing of the Apps.
     */
    public function index()
    {
        return response()->json(App::all());
    }

    /**
     * Store a newly created App in storage.
     */
    public function store(Request $request, )
    {
        
    }

    /**
     * Display the specified App.
     */
    public function show($id)
    {
        $app = App::find($id);
        return response()->json($app);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
