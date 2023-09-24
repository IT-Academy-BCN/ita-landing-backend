<?php 

namespace App\Annotations\OpenApi\modelsAnnotations\appAnnotations;

use OpenApi as OA;

/**
 * @OA\Schema(
 *     title="App",
 *     description="App model",
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
 *         example="My application"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description",
 *         example="Description of my application"
 *     ),
 *     @OA\Property(
 *         property="url",
 *         type="string",
 *         description="URL",
 *         example="https://myapp.com"
 *     ),
 *     @OA\Property(
 *         property="state",
 *         type="string",
 *         description="State",
 *         enum={"COMPLETED", "IN PROGRESS", "SOON"},
 *         example="COMPLETED"
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
 *     )
 * )
 */


class AnnotationsApp {}