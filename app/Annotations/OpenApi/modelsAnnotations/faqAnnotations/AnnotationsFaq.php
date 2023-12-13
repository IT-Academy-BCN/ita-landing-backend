<?php

namespace App\Annotations\OpenApi\modelsAnnotations\faqAnnotations;

use OpenApi as OA;
/** ------- AnnotationsFaq {} -------//
 * @OA\Schema(
 *     title="Faq",
 *     description="Faq model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp",
 *         example="2023-06-19T12:00:00+00:00"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp",
 *         example="2023-06-19T13:30:00+00:00"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title",
 *         example="FAQ Title"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description",
 *         example="FAQ Description"
 *     ),
 *     @OA\Property(
 *         property="translations",
 *         type="array",
 *         description="Array of translations",
 *         @OA\Items(ref="#/components/schemas/AnnotationsFaqTranslation"),
 *         example={
 *           {
 *             "id": 1,
 *             "faq_id": 1,
 *             "title": "Títol de la meva pregunta freqüent",
 *             "description": "Descripció de la meva pregunta freqüent",
 *             "locale": "ca"
 *           },
 *           {
 *             "id": 2,
 *             "faq_id": 1,
 *             "title": "Título de mi pregunta frecuente",
 *             "description": "Descripción de mi pregunta frecuente",
 *             "locale": "es"
 *           },
 *           {
 *             "id": 3,
 *             "faq_id": 1,
 *             "title": "Title of my frequently asked question",
 *             "description": "Description of my frequently asked question",
 *             "locale": "en"
 *           }
 *         }
 *     ),
 * )
 */

class AnnotationsFaq {}

/** ------ AnnotationsFaqTranslation {} ------ //
 * @OA\Schema(
 *     title="FaqTranslation",
 *     description="Faq translation model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Translation ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="faq_id",
 *         type="integer",
 *         description="Faq ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Translated title",
 *         example="Títol de la meva pregunta freqüent"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Translated description",
 *         example="Descripció de la meva pregunta freqüent"
 *     ),
 *     @OA\Property(
 *         property="locale",
 *         type="string",
 *         description="Locale code",
 *         example="ca"
 *     ),
 * )
 */
class AnnotationsFaqTranslation {}

/** ------- AnnotationsFaqStored {} -------//
 * @OA\Schema(
 *     title="Faq",
 *     description="Faq model",
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp",
 *         example="2023-06-19T12:00:00+00:00"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp",
 *         example="2023-06-19T13:30:00+00:00"
 *     ),
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title",
 *         example="FAQ Title"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description",
 *         example="FAQ Description"
 *     ),
 *     @OA\Property(
 *         property="translations",
 *         type="array",
 *         description="Array of translations",
 *         @OA\Items(ref="#/components/schemas/AnnotationsFaqTranslation"),
 *         example={
 *           "locale": "ca",
 *           "title": "Títol de la meva pregunta freqüent",
 *           "description": "Descripció de la meva pregunta freqüent",
 *           "faq_id": 1,
 *           "id": 1
 *         }
 *     ),
 * )
 */

 class AnnotationsFaqStored {}
