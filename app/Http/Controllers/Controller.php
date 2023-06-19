<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *   title="IT Landing page API",
 *   version="1.0.0",
 *   description="Documentation needed for the API Rest for the landing page to IT Academy. Some useful links above:
 *   [ITA Landing Backend](https://github.com/IT-Academy-BCN/ita-landing-backend)
 *   [ITA Landing Frontend](https://github.com/IT-Academy-BCN/ita-landing-frontend)"
 * )
 *   @OA\Server(
 *     url="http://127.0.0.1:8000/api"
 *   )
 * )
 *
 * @OA\Tag(
 *   name="User",
 *   description="Operations for a user"
 * )
 *
 * @OA\Tag(
 *   name="Apps",
 *   description="Operations for an app"
 * )
 *
 * @OA\Tag(
 *   name="Faqs",
 *   description="Operations for a faq"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
