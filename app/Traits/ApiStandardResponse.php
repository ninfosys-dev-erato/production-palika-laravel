<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiStandardResponse
{
    public static function fromException(\Exception $exception): JsonResponse
    {
        $statusCode = $exception->getCode(); // Check if exception has a custom status code
        // Use the custom status code if available, otherwise use the default one
        $httpStatusCode = $statusCode ? $statusCode : Response::HTTP_EXPECTATION_FAILED;

        return response()->json([
            'status' => false,
            'message' => $exception->getMessage()
        ], $httpStatusCode);
    }

    public static function lockElseHandler():JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => 'Unable to process request, please try again later.'
        ], Response::HTTP_TOO_MANY_REQUESTS);
    }

    public function propertiesToArray(?array $selectedProperties = null): array
    {
        $properties = get_object_vars($this);

        if ($selectedProperties !== null) {
            $properties = array_intersect_key($properties, array_flip($selectedProperties));
        }

        return $properties;
    }

    public function generalSuccess(array $parameters = [],$response_code = Response::HTTP_OK):JsonResponse{
        return response()->json([
            'status' => true,
            ...$parameters
        ], $response_code);
    }

    public function generalFailure(array $parameters = [],$response_code = Response::HTTP_EXPECTATION_FAILED):JsonResponse{
        return response()->json([
            'status' => false,
            ...$parameters
        ], $response_code);
    }
}
