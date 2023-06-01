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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'required|url',
            'state' => 'required|in:COMPLETED,IN PROGRESS,SOON',
        ]);
        
        $app = App::create($validatedData);
        return response()->json($app, 201);
    }

    /**
     * Display the specified App.
     */
    public function show($id)
    {
        $app = App::findOrFail($id);
        return response()->json($app);
    }

    /**
     * Update the specified App in storage.
     */
    public function update(Request $request, $id)
    {
        $app = App::findOrFail($id); 

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'required|url',
            'state' => 'required|in:COMPLETED,IN PROGRESS,SOON',
        ]);

        $app->update($validatedData);
        return response()->json($app, 200);
    }

    /**
     * Remove the specified App from storage.
     */
    public function destroy($id)
    {
        $app = App::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
