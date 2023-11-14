<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
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

        return response()->json([
            'id' => $faq->id,
            'title' => $faq->title,
            'description' => $faq->description,
            'created_at' => $faq->created_at,
            'updated_at' => $faq->updated_at,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
            ]);

            $faq = Faq::create($validatedData);

            return response()->json(['faq' => $faq], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $faqs = Faq::find($id);

            if (! $faqs) {
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
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $faqs = Faq::find($id);

        if (! $faqs) {
            return response()->json(['error' => 'FAQ not found'], 404);
        }

        $faqs->delete();

        return response()->json(['message' => 'FAQ deleted successfully']);
    }
}
