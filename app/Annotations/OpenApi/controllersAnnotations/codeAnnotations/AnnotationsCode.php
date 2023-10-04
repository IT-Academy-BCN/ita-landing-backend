<?php

namespace App\Annotations\OpenApi\controllersAnnotations\codeAnnotations;

class AnnotationsCode {

    /** @OA\Post(
     *     path="/send-code-by-email",
     *     tags={"User"},
     *     summary="Send a code by email.",
     *     description="Sends a generated code to the specified email address.",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="The email address to send the code to.",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="email"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Email sent successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid email"),
     *             @OA\Property(property="errors", type="object", example={"email": {"The email field is required."}})
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */

    public function sendCodeByEmail() {}
}