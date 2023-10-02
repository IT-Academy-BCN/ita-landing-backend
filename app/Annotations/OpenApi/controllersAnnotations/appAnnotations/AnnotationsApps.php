<?php 

namespace App\Annotations\OpenApi\controllersAnnotations\appAnnotations;

class AnnotationsApps {

    /**
 * @OA\Get(
 *   path="/apps",
 *   tags={"Apps"},
 *   summary="Apps list",
 *   description="This endpoint is used to take a list of all the apps",
 *   @OA\Response(
 *     response="200",
 *     description="Apps list."
 *   )
 * )
 */
    public function index() {}

/**
 * @OA\Post(
 *   path="/apps",
 *   tags={"Apps"},
 *   summary="Create a new app",
 *   description="This endpoint is used to create a new application.",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="title",
 *           type="string",
 *           example="My application"
 *         ),
 *         @OA\Property(
 *           property="description",
 *           type="string",
 *           example="Description of my application"
 *         ),
 *         @OA\Property(
 *           property="url",
 *           type="string",
 *           example="https://myapp.com"
 *         ),
 *         @OA\Property(
 *           property="github",
 *           type="string",
 *           example="https://github.com/IT-Academy-BCN/project-1"
 *         ),
 *         @OA\Property(
 *           property="state",
 *           type="string",
 *           example="COMPLETED",
 *           enum={"COMPLETED", "IN PROGRESS", "SOON"}
 *         )
 *       )
 *     )
 *   ),
 *   security={{"bearer": {}}},
 *   @OA\Response(
 *     response="201",
 *     description="Details of the application created."
 *   )
 * )
 */
    public function store() {}

    /**
 * @OA\Get(
 *   path="/apps/{id}",
 *   tags={"Apps"},
 *   summary="Get details of an application",
 *   description="This endpoint is used to get the details of a specific application.",
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     description="Application ID.",
 *     @OA\Schema(
 *       type="integer",
 *       example=1
 *     )
 *   ),
 *   security={{"bearer": {}}},
 *   @OA\Response(
 *     response="200",
 *     description="Details of the application."
 *   )
 * )
 */  
    public function show() {}

    /**
 * @OA\Put(
 *   path="/apps/{id}",
 *   tags={"Apps"},
 *   summary="Update an existing app",
 *   description="This endpoint is used to update the details of an existing application.",
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     description="Application ID.",
 *     @OA\Schema(
 *       type="integer",
 *       example=1
 *     )
 *   ),
 *   security={{"bearer": {}}},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="title",
 *           type="string",
 *           example="New title of my application"
 *         ),
 *         @OA\Property(
 *           property="description",
 *           type="string",
 *           example="New description of my application"
 *         ),
 *         @OA\Property(
 *           property="url",
 *           type="string",
 *           example="https://myapp.com/new-version"
 *         ),
 *          @OA\Property(
 *           property="github",
 *           type="string",
 *           example="https://github.com/IT-Academy-BCN/project-1"
 *         ),
 *         @OA\Property(
 *           property="state",
 *           type="string",
 *           example="IN PROGRESS",
 *           enum={"COMPLETED", "IN PROGRESS", "SOON"}
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="Updated application details."
 *   )
 * )
 */
    public function update() {}

    /**
 * @OA\Delete(
 *   path="/apps/{id}",
 *   tags={"Apps"},
 *   summary="Delete an app",
 *   description="This endpoint is used to remove an existing application.",
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     description="Application ID.",
 *     @OA\Schema(
 *       type="integer",
 *       example=1
 *     )
 *   ),
 *   security={{"bearer": {}}},
 *   @OA\Response(
 *     response="200",
 *     description="Success message indicating that the application has been removed."
 *   )
 * )
 */
    public function destroy() {}
}