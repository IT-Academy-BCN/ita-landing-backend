<?php

namespace App\Annotations\OpenApi\controllersAnnotations\usersAnnotations;

class AnnotationsUsers
{
    /**
     * @OA\Post(
     *   path="/register",
     *   tags={"User"},
     *   summary="User Register",
     *   description="This endpoint is used to register a new user in the application.",
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
     *           property="email",
     *           type="string",
     *           example="example@example.com"
     *         ),
     *         @OA\Property(
     *           property="name",
     *           type="string",
     *           example="John Doe"
     *         ),
     *         @OA\Property(
     *           property="dni",
     *           type="string",
     *           example="12345678A"
     *         ),
     *         @OA\Property(
     *           property="password",
     *           type="string",
     *           example="password123"
     *         ),
     *         @OA\Property(
     *           property="password_confirmation",
     *           type="string",
     *           example="password123"
     *         )
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response="200",
     *     description="User created successfully."
     *   )
     * )
     */
    public function store()
    {
    }

    /**
 * @OA\Post(
 *   path="/forget-password",
 *   tags={"User"},
 *   summary="send email to recovery password",
 *   description="This endpoint is used send an email to a register user to reset the password.",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="email",
 *           type="string",
 *           example="example@example.com"
 *         ),
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="check your email"
 *   ),
 *   @OA\Response(
 *     response="404",
 *     description="The email don\'t exist"
 *   )
 * )
 */
    public function forgetPassword() {}

    /**
 * @OA\Post(
 *   path="/reset-password/{token}",
 *   tags={"User"},
 *   summary="User recovery password",
 *   description="This endpoint is used to update the password of the user.",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="token",
 *           type="string",
 *           example="abcdefghij"
 *         ),
 *          @OA\Property(
 *           property="password",
 *           type="string",
 *           example="password"
 *         ),
 *          @OA\Property(
 *           property="password_confirm",
 *           type="string",
 *           example="password"
 *         ),
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="success"
 *   ),
 *   @OA\Response(
 *     response="400",
 *     description="Invalid Token!"
 *   )
 * )
 */
    public function resetPassword() {}
}
