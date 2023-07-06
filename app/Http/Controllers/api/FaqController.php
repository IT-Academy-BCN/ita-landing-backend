<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Validation\ValidationException;

class FaqController extends Controller
{
/**
 * @OA\Get(
 *   path="/faqs",
 *   tags={"Faqs"},
 *   summary="Get list of frequently asked questions (FAQs)",
 *   description="This endpoint is used to get a list of all frequently asked questions.",  
 * @OA\Response(
 *     response="200",
 *     description="Frequently asked questions list."
 *   )
 * )
 */
    public function index()
    {
        return response()->json(['faqs' => Faq::all()]);
    }

/**
 * @OA\Get(
 *   path="/faqs/{id}",
 *   tags={"Faqs"},
 *   summary="Get details of a specific Frequently Asked Question (FAQ)",
 *   description="This endpoint is used to get the details of a specific FAQ.",
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     description="FAQ ID.",
 *     @OA\Schema(
 *       type="integer",
 *       example=1
 *     )
 *   ),
 *   security={{"bearer": {}}},
 *   @OA\Response(
 *     response="200",
 *     description="FAQ details."
 *   )
 * )
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
 * @OA\Post(
 *   path="/faqs",
 *   tags={"Faqs"},
 *   summary="Create a new Frequently Asked Question (FAQ)",
 *   description="This endpoint is used to create a new FAQ.",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="title",
 *           type="string",
 *           example="My frequently asked question"
 *         ),
 *         @OA\Property(
 *           property="description",
 *           type="string",
 *           example="Description of my FAQ"
 *         )
 *       )
 *     )
 *   ),
 *   security={{"bearer": {}}},
 *   @OA\Response(
 *     response="201",
 *     description="Details of the FAQ created."
 *   )
 * )
 */
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

/** 
 * @OA\Put(
 *   path="/faqs/{id}",
 *   tags={"Faqs"},
 *   summary="Update an existing Frequently Asked Question (FAQ)",
 *   description="This endpoint is used to update the details of an existing FAQ.",
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     description="FAQ ID",
 *     @OA\Schema(
 *       type="integer",
 *       example=1
 *     )
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="title",
 *           type="string",
 *           example="New title of my FAQ"
 *         ),
 *         @OA\Property(
 *           property="description",
 *           type="string",
 *           example="New description of my FAQ"
 *         )
 *       )
 *     )
 *   ),
 *   security={{"bearer": {}}},
 *   @OA\Response(
 *     response="200",
 *     description="Updated FAQ details."
 *   )
 * )
 */
    public function update(Request $request, $id)
    {
        try {
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
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

/**
 * @OA\Delete(
 *   path="/faqs/{id}",
 *   tags={"Faqs"},
 *   summary="Delete a frequently asked question (FAQ)",
 *   description="This endpoint is used to delete an existing FAQ.",
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     description="FAQ ID",
 *     @OA\Schema(
 *       type="integer",
 *       example=1
 *     )
 *   ),
 *   security={{"bearer": {}}},
 *   @OA\Response(
 *     response="200",
 *     description="Success message indicating that the FAQ has been removed."
 *   )
 * )
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
