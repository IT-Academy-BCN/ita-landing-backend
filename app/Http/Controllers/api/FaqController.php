<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Validation\ValidationException;

class FaqController extends Controller
{
    public function index()
    {
        return response()->json(['faqs' => Faq::all()]);
    }

    public function show($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json(
                ['error' => __('api.faq_not_found')],
                404
            );
        }

        return response()->json($faq);
    }

    public function store(Request $request)
    {
        try {

            $rules = RuleFactory::make([
                '%title%' => ['required', 'string', 'max:255'],
                '%description%' => ['required_with:%title%', 'string'],
            ]);

            $validatedData = $request->validate($rules);


            $faq = Faq::create($validatedData);

            return response()->json(['faq' => $faq], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $faq = Faq::find($id);

            if (!$faq) {
                return response()->json(['error' => __('api.faq_not_found')], 404);
            }

            $rules = RuleFactory::make([
                '%title%' => ['string', 'max:255'],
                '%description%' => ['string'],
            ]);

            $validatedData = $request->validate($rules);

            $faq->update($validatedData);
            return response()->json(['message' => __('api.faq_updated')], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $faqs = Faq::find($id);

        if (!$faqs) {
            return response()->json(['error' => __('api.faq_not_found')], 404);
        }

        $faqs->delete();

        return response()->json(['message' => __('api.faq_deleted')]);
    }
}
