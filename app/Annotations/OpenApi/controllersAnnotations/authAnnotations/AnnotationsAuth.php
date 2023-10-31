<?php

namespace App\Annotations\OpenApi\controllersAnnotations\authAnnotations;

class AnnotationsAuth {

/**
 * @OA\Post(
 *   path="/login",
 *   tags={"User"},
 *   summary="Login",
 *   description="This endpoint is used for a user to log into the app and get an access token.",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="dni",
 *           type="string",
 *           example="12345678A"
 *         ),
 *         @OA\Property(
 *           property="password",
 *           type="string",
 *           example="password123"
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="Access token for the user. The response message may vary based on user's language settings."
 *   )
 * )
 */
    public function loginUser() {}
}
