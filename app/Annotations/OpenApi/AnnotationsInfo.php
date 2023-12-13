<?php

namespace App\Annotations\OpenApi;

/**
 * @OA\Info(
 * title="ITA Landing page API documentation",
 * version="1.0.0",
 * description="Documentation needed for the API Rest for the landing page to IT Academy.
 *   This API supports Catalan, Spanish and English languages using the 'Accept-Language' header. Defaults Catalan.
 *   Also it is possible to add FAQs in a different language to the current one by using the language parameter.
 *     Some useful links below:
 * [ITA Landing Backend](https://github.com/IT-Academy-BCN/ita-landing-backend)
 * [ITA Landing Frontend](https://github.com/IT-Academy-BCN/ita-landing-frontend)",
 * )
 * @OA\Server(
 *     url= L5_SWAGGER_CONST_HOST
 * )
 */
    class AnnotationsInfo {}
