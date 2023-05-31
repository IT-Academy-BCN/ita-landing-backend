<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Get a list of all faqs.
     *
     * @param
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['faqs' => Faq::all()]);
    }

    /**
     * Get an specific FAQ.
     *
     * @param Faq $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $faq = Faq::find($id);

        return response()->json([
            'id' => $faq->id,
            'title' => $faq->title,
            'description' => $faq->description,
            'created_at'=> $faq->created_at,
            'updated_at' => $faq->updated_at
        ]);
    }

    /**
     * Save a new FAQ from request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $faq = Faq::create($validatedData);

        return response()->json(['faq' => $faq], 201);
    }

    /**
     * Update specific FAQ.
     *
     * @param  Request  $request
     * @param  Faq  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $faqs = Faq::find($id);

        if (!$faqs) {
            return response()->json(['error' => 'FAQ not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $faqs->title = $validatedData['title'];
        $faqs->description = $validatedData['description'];
        $faqs->save();

        return response()->json(['message' => 'FAQ updated successfully']);
    }

    /**
     * Delete a specific FAQ.
     *
     * @param  Request  $request
     * @param  Faq  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $faqs = Faq::find($id);

        if (!$faqs) {
            return response()->json(['error' => 'FAQ not found'], 404);
        }

        $faqs->delete();

        return response()->json(['message' => 'FAQ deleted successfully']);
    }
}
