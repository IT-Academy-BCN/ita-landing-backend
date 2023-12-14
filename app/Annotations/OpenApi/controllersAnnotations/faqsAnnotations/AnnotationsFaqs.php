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
     *
     * @OA\Response(
     *     response="200",
     *     description="Frequently asked questions list."
     *   )
     * )
     */
    public function index()
    {
    }

    /** ------INDEX------ //
     * @OA\Get(
     *   path="/faqs",
     *   tags={"Faqs"},
     *   summary="Get list of frequently asked questions (FAQs)",
     *   description="This endpoint is used to get a list of all frequently asked questions.",
     *
     * @OA\Response(
     *     response="200",
     *     description="Frequently asked questions list."
     *   )
     * )
     */
    public function index()
    {
    }

    /** ------SHOW------ //
     * @OA\Get(
     *   path="/faqs/{id}",
     *   tags={"Faqs"},
     *   summary="Get details of a specific Frequently Asked Question (FAQ) with all its available translations",
     *   description="This endpoint is used to get the details of a specific FAQ and its available translations.
     *     For translations in a specific language, use the /faqs/{id}?language endpoint.",
     *   security={{"bearer": {}}},
     *
     *   @OA\Parameter(
     *     name="Accept-Language",
     *     in="header",
     *     required=false,
     *     description="Language code (e.g., ca, es, en).",
     *
     *     @OA\Schema(
     *       type="string",
     *       example="ca"
     *     )
     *   ),
     *
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="FAQ ID.",
     *
     *     @OA\Schema(
     *       type="integer",
     *       example=1
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response="200",
     *     description="FAQ details.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="faq", type="object", ref="#/components/schemas/AnnotationsFaq"),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="404",
     *     description="FAQ not found.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="error", type="string", example="FAQ not found"),
     *     ),
     *   ),
     *
     *     @OA\Response(
     *     response="422",
     *     description="Translation key not available.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="error", type="string",
     *       example="Translation key not available."),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="406",
     *     description="FAQ Translation not available.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="error", type="string",
     *       example="FAQ translation not available."),
     *     ),
     *   ),
     * ),
     *
     * @OA\Get(
     *   path="/faqs/{id}?language",
     *   tags={"Faqs"},
     *   summary="Get details of a specific Frequently Asked Question (FAQ) in a specific language",
     *   description="This endpoint is used to get the details of a specific FAQ in a specific language.
     *     To get a response with all the available translations use the /faqs/{id} endpoint.",
     *   security={{"bearer": {}}},
     *
     *   @OA\Parameter(
     *     name="Accept-Language",
     *     in="header",
     *     required=false,
     *     description="Language code (e.g., ca, es, en).",
     *
     *     @OA\Schema(
     *       type="string",
     *       example="ca"
     *     )
     *   ),
     *
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="FAQ ID.",
     *
     *     @OA\Schema(
     *       type="integer",
     *       example=1
     *     )
     *   ),
     *
     *   @OA\Parameter(
     *     name="language",
     *     in="query",
     *     required=true,
     *     description="Language code (e.g., ca, es, en).",
     *
     *     @OA\Schema(
     *       type="string",
     *       example="ca",
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response="200",
     *     description="FAQ details in the specified language.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="faq", type="object", ref="#/components/schemas/AnnotationsFaqTranslation"),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="404",
     *     description="FAQ not found.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="error", type="string", example="FAQ not found"),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="422",
     *     description="Translation key not available.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="error", type="string",
     *       example="Translation key not available."),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="406",
     *     description="FAQ Translation not available.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="error", type="string",
     *       example="FAQ translation not available."),
     *     ),
     *   ),
     * )
     */
    public function show()
    {
    }

    /** ------STORE------ //
     * @OA\Post(
     *   path="/faqs?language",
     *   tags={"Faqs"},
     *   summary="Create a new Frequently Asked Question (FAQ) in a specific language",
     *   description="This endpoint is used to create a new FAQ in Catalan, Spanish or English.
     *     To save a new translation of an existentent FAQ please use the Update endpoint.",
     *   security={{"bearer": {}}},
     *
     *   @OA\Parameter(
     *     name="Accept-Language",
     *     in="header",
     *     required=false,
     *     description="Language code (e.g., ca, es, en). The language of the aplication",
     *
     *     @OA\Schema(
     *       type="string",
     *       example="ca"
     *     )
     *   ),
     *
     *   @OA\Parameter(
     *     name="language",
     *     in="query",
     *     required=true,
     *     description="Language code (e.g., ca, es, en). The language in the FAQ is going to be saved.",
     *
     *     @OA\Schema(
     *       type="string",
     *       example="ca"
     *     )
     *   ),
     *
     *   @OA\RequestBody(
     *     required=true,
     *
     *     @OA\MediaType(
     *       mediaType="application/json",
     *
     *       @OA\Schema(
     *
     *         @OA\Property(
     *           property="title",
     *           type="string",
     *           example="Títol de la meva pregunta freqüent"
     *           ),
     *         @OA\Property(
     *           property="description",
     *           type="string",
     *           example="Descripció de la meva pregunta freqüent"
     *         ),
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response="201",
     *     description="Details of the FAQ created.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="faq", type="object", ref="#/components/schemas/AnnotationsFaqStored"),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="422",
     *     description="Translation code key not available or validation fail.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(
     *         property="errors",
     *         type="object",
     *           @OA\Property(property="title", type="array", collectionFormat="multi",
     *
     *             @OA\Items(
     *               type="string",
     *               example="The title has already been taken.",
     *             ),
     *           ),
     *         ),
     *       ),
     *     ),
     *   ),
     * )
     */
    public function store()
    {
    }

    /** ------UPDATE------ //
     * @OA\Put(
     *   path="/faqs/{id}",
     *   tags={"Faqs"},
     *   summary="Update an existing Frequently Asked Question (FAQ)",
     *   description="This endpoint is used to update the details of an existing FAQ.",
     *   security={{"bearer": {}}},
     *
     *   @OA\Parameter(
     *     name="Accept-Language",
     *     in="header",
     *     required=false,
     *     description="Language code (e.g., ca, es, en). The language of the aplication",
     *
     *     @OA\Schema(
     *       type="string",
     *       example="ca"
     *     ),
     *   ),
     *
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="FAQ ID",
     *
     *     @OA\Schema(
     *       type="integer",
     *       example=1
     *     ),
     *   ),
     *
     *   @OA\Parameter(
     *     name="language",
     *     in="query",
     *     required=true,
     *     description="Language code (e.g., ca, es, en). The language in the FAQ is going to be saved.",
     *
     *     @OA\Schema(
     *       type="string",
     *       example="ca"
     *     ),
     *   ),
     *
     *   @OA\RequestBody(
     *     required=true,
     *
     *     @OA\MediaType(
     *       mediaType="application/json",
     *
     *       @OA\Schema(
     *
     *         @OA\Property(
     *           property="title",
     *           type="string",
     *           example="Títol de la meva pregunta freqüent"
     *           ),
     *         @OA\Property(
     *           property="description",
     *           type="string",
     *           example="Descripció de la meva pregunta freqüent"
     *         ),
     *       ),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="404",
     *     description="FAQ not found.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="error", type="string", example="FAQ not found"),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="200",
     *     description="Updated FAQ details.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Faq actualitzada correctament.",
     *         ),
     *       @OA\Property(property="faq", type="object", ref="#/components/schemas/AnnotationsFaq"),
     *       )
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="422",
     *     description="Translation key not available.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="error", type="string",
     *       example="Translation key not available."),
     *     ),
     *   ),
     * )
     */
    public function update()
    {
    }

    /** ------DELETE------ //
     * @OA\Delete(
     *   path="/faqs/{id}",
     *   tags={"Faqs"},
     *   summary="Delete a frequently asked question (FAQ)",
     *   description="This endpoint is used to delete an existing FAQ or its translation.
     *     If the language parameter is not provided the whole FAQ will be deleted",
     *   security={{"bearer": {}}},
     *
     *   @OA\Parameter(
     *     name="Accept-Language",
     *     in="header",
     *     required=false,
     *     description="Language code (e.g., ca, es, en). The language of the aplication",
     *
     *     @OA\Schema(
     *       type="string",
     *       example="ca"
     *     )
     *   ),
     *
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="FAQ ID",
     *
     *     @OA\Schema(
     *       type="integer",
     *       example=1
     *     )
     *   ),
     *
     *   @OA\Parameter(
     *     name="language",
     *     in="query",
     *     required=false,
     *     description="Language code (e.g., ca, es, en). The language of the FAQ translation that will be deleted.",
     *
     *     @OA\Schema(
     *       type="string",
     *       example="ca"
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response="422",
     *     description="Translation key not available.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="error", type="string",
     *       example="Translation key not available."),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="404",
     *     description="FAQ not found.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="error", type="string", example="FAQ not found"),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="406",
     *     description="FAQ Translation not available.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(property="error", type="string",
     *       example="FAQ translation not available."),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response="200",
     *     description="Success message indicating that the FAQ or a FAQ translation has been removed.",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="FAQ translation successfully deleted.",
     *       ),
     *     ),
     *   ),
     * )
     */
    public function delete()
    {
    }
}
