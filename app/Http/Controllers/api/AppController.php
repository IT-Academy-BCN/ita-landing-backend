<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\App;

class AppController extends Controller
{

    public function index()
    {
        return response()->json(App::all());
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'required|url',
            'github' => 'required|url',
            'state' => 'required|in:COMPLETED,IN PROGRESS,SOON',
        ]);
        
        $app = App::create($validatedData);
        return response()->json($app, 201);
    }

  
    public function show($id)
    {
        $app = App::findOrFail($id);
        return response()->json($app);
    }


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

    public function destroy($id)
    {
        $app = App::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
