<?php 

namespace App\Annotations\OpenApi\collaboratorsAnnotations;

class AnnotationsCollaborators {

    /**
 * @OA\Get(
 *   path="/collaborators/{area}",
 *   tags={"Collaborators"},
 *   summary="User Collaborators",
 *   description="This endpoint is used to get persons that work on the specific project",
 *   @OA\Parameter(
 *     name="area",
 *     in="path",
 *     required=true,
 *     description="name of the area",
 *     @OA\Schema(
 *       type="string",
 *       example="landing"
 *     )
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="Collaborators details.",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         type="array",
 *         property="rows",
 *         @OA\Items(
 *           type="object",
 *           @OA\Property(
 *             property="name",
 *             type="string",
 *             example="CloudSalander"
 *           ),
 *           @OA\Property(
 *             property="photo",
 *             type="string",
 *             example="https://avatars.githubusercontent.com/u/1247767?v=4"
 *           ),
 *           @OA\Property(
 *             property="url",
 *             type="string",
 *             example="https://api.github.com/users/CloudSalander"
 *           )
 *         )
 *       )
 *     )
 *   )
 * )
 */

    public function index() {}
}