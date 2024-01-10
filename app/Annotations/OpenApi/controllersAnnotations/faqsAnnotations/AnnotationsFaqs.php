<?php

namespace App\Annotations\OpenApi\controllersAnnotations\faqsAnnotations;

class AnnotationsFaqs
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
   public function show()
   {
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
 *           property="ca",
 *           type="object",
 *           @OA\Property(
 *             property="title",
 *             type="string",
 *             example="Títol de la meva pregunta freqüent"
 *           ),
 *           @OA\Property(
 *             property="description",
 *             type="string",
 *             example="Descripció de la meva pregunta freqüent"
 *           ),
 *         ),
 *         @OA\Property(
 *           property="es",
 *           type="object",
 *           @OA\Property(
 *             property="title",
 *             type="string",
 *             example="Título de mi pregunta frecuente"
 *           ),
 *           @OA\Property(
 *             property="description",
 *             type="string",
 *             example="Descripción de mi pregunta frecuente"
 *           ),
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
   public function store()
   {
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
 *           property="ca",
 *           type="object",
 *           @OA\Property(
 *             property="title",
 *             type="string",
 *             example="Nou títol de FAQ"
 *           ),
 *           @OA\Property(
 *             property="description",
 *             type="string",
 *             example="Nova descripció de FAQ"
 *           ),
 *         ),
 *         @OA\Property(
 *           property="es",
 *           type="object",
 *           @OA\Property(
 *             property="title",
 *             type="string",
 *             example="Nueva descripción de FAQ"
 *           ),
 *           @OA\Property(
 *             property="description",
 *             type="string",
 *             example="Nueva descripción de GAQ"
 *           ),
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
   public function update()
   {
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
   public function delete()
   {
   }
}
