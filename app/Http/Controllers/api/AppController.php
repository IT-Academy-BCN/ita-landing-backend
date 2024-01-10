<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\App;
use Illuminate\Http\Request;
use Astrotomic\Translatable\Validation\RuleFactory;
use Exception;

class AppController extends Controller
{
    public function index()
    {
        return response()->json(App::all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'url' => 'required|url',
            'github' => 'required|url',
            'state' => 'required|in:COMPLETED,IN PROGRESS,SOON',
        ]);

        $rules = RuleFactory::make([
            '%title%' => 'required|string|max:255',
            '%description%' => 'required_with:"%title%"|string',
        ]);

        $validatedData += $request->validate($rules);

        $app = App::create($validatedData);

        return response()->json($app, 201);
    }

    public function show($id)
    {
        $app = App::find($id);

        if (!$app) {
            return response()->json(['error' => __('api.app_not_found')], 404);
        }

        return response()->json($app);
    }

    public function update(Request $request, $id)
    {
        try {
            $app = App::find($id);

            if (!$app) {
                return response()->json(['error' => __('api.app_not_found')], 204);
            }

            $rules = RuleFactory::make([
                '%title%' => ['required', 'string', 'max:255'],
                '%description%' => ['string']
            ]);

            $validatedData = $request->validate([
                'url' => 'url:http,https',
                'github' => 'url:http,https',
                'state' => 'in:COMPLETED,IN PROGRESS,SOON'
            ]);
            $validatedData += $request->validate($rules);

            $app->update($validatedData);
            return response()->json(['message' => __('api.app_updated'), 200]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        $app = App::find($id);

        if (!$app) {
            return response()->json(['error' => __('api.app_not_found')], 404);
        }
        $app->delete();

        return response()->json(['message' => __('api.app_deleted')]);
    }
}
