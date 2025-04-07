<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Food App API Documentation",
 *     version="1.0.0",
 *     description="API documentation for Food App",
 *     @OA\Contact(
 *         email="support@foodapp.com",
 *         name="Support Team"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     description="Food App API Server",
 *     url=L5_SWAGGER_CONST_HOST
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     securityScheme="bearerAuth",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
