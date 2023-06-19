<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\App;

class AppController extends Controller
{
/**
 * @OA\Get(
 *   path="/apps",
 *   tags={"Apps"},
 *   summary="Apps list",
 *   description="This endpoint is used to take a list of all the apps",
 *   @OA\Response(
 *     response="200",
 *     description="Apps list."
 *   )
 * )
 */
    public function index()
    {
        return response()->json(App::all());
    }

/**
 * @OA\Post(
 *   path="/apps",
 *   tags={"Apps"},
 *   summary="Create a new app",
 *   description="This endpoint is used to create a new application.",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="title",
 *           type="string",
 *           example="My application"
 *         ),
 *         @OA\Property(
 *           property="description",
 *           type="string",
 *           example="Description of my application"
 *         ),
 *         @OA\Property(
 *           property="url",
 *           type="string",
 *           example="https://myapp.com"
 *         ),
 *         @OA\Property(
 *           property="state",
 *           type="string",
 *           example="COMPLETED",
 *           enum={"COMPLETED", "IN PROGRESS", "SOON"}
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response="201",
 *     description="Details of the application created."
 *   )
 * )
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
