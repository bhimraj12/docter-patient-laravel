<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Throwable;

trait APIResponse
{
    use Paginatable;

    protected $statusCode = 200;

    protected array $additionalData = [];

    const UNAUTHENTICATED = 401;

    const FORBIDDEN = 403;

    const CONFLICT = 409;

    const SUCCESS = 200;

    const NOTFOUND = 404;

    const CREATED = 201;

    const UNPROCESSED = 422;

    const BADREQUEST = 400;

    const ERROR = 500;

    const GONE = 410;

    public function createdResponse($message = 'Record created successfully!', $data = [], $headers = [])
    {
        $responseData = [
            'code' => self::CREATED,
            'message' => $message,
        ];

        if (! empty($data)) {
            $responseData += [
                'data' => $data,
            ];
        }

        return $this->setStatusCode(self::CREATED)->apiResponse($responseData, $headers);
    }

    public function successResponse($message = 'Ok', $data = [], $headers = [])
    {
        $responseData = [
            'code' => self::SUCCESS,
            'message' => $message,
        ];

        if (! empty($data)) {
            $responseData += [
                'data' => $data,
            ];
        }

        return $this->setStatusCode(self::SUCCESS)->apiResponse($responseData, $headers);
    }

    public function notFoundResponse($message = 'Record not found!', $headers = [])
    {
        return $this->setStatusCode(self::NOTFOUND)->apiResponse([
            'code' => self::NOTFOUND,
            'message' => $message,
        ], $headers);
    }

    public function dataResponse($data, $headers = [])
    {
        return $this->setStatusCode(self::SUCCESS)->apiResponse(array_merge([
            'code' => self::SUCCESS,
            'data' => $data,
        ], $this->additionalData), $headers);
    }

    public function paginatedDataResponse($data, ?string $resource = null, $headers = [])
    {
        $pagination = $this->generatePagination($data);

        // If a resource class is provided, transform the data using the resource
        if ($resource) {
            $data = $resource::collection($data);
        }

        return $this->setStatusCode(self::SUCCESS)->apiResponse(array_merge([
            'code' => self::SUCCESS,
            'data' => $data,
        ], $pagination, $this->additionalData), $headers);
    }

    public function unauthorizedResponse($message = 'Unauthorized!', $headers = [])
    {
        return $this->setStatusCode(self::FORBIDDEN)->apiResponse([
            'code' => self::FORBIDDEN,
            'message' => $message,
        ], $headers);
    }

    public function unauthenticatedResponse($message = 'Unauthenticated!', $headers = [])
    {
        return $this->setStatusCode(self::UNAUTHENTICATED)->apiResponse([
            'code' => self::UNAUTHENTICATED,
            'message' => $message,
        ], $headers);
    }

    public function errorResponse($message = 'Bad Request!', $code = self::BADREQUEST, $data = [], $headers = [])
    {
        $responseData = [
            'code' => $code,
            'message' => $message,
        ];

        if (! empty($data)) {
            $responseData += [
                'data' => $data,
            ];
        }

        return $this->setStatusCode($code)->apiResponse($responseData, $headers);
    }

    public function conflictResponse($message = 'Conflict!')
    {
        return $this->setStatusCode(self::CONFLICT)->apiResponse([
            'code' => self::CONFLICT,
            'message' => $message,
        ]);
    }

    public function internalErrorResponse(null|string|Throwable $error = null, string $message = 'Internal Server Error')
    {
        // Initialize structured error data
        $errorData = [
            'message' => $message,
            'details' => null,
        ];

        // Check if an error was provided
        if ($error !== null) {
            if ($error instanceof Throwable) {
                // Extract detailed information if it's a Throwable
                $errorData['details'] = [
                    'error_message' => $error->getMessage(),
                    'file' => $error->getFile(),
                    'line' => $error->getLine(),
                    'trace' => $error->getTraceAsString(),
                ];
            } else {
                // Treat it as a simple string message if not Throwable
                $errorData['details'] = [
                    'error_message' => $error,
                ];
            }
        }

        // Log the structured error data
        Log::error('Internal Error Occurred', $errorData);

        // Return the error response
        return $this->errorResponse($message, 500);
    }

    // Add a additional data with key and value pairs to the response
    public function addAdditional(string $key, string|array|bool $data)
    {
        $this->additionalData[$key] = $data;

        return $this;
    }

    public function apiResponse($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    public function setStatusCode($code = self::SUCCESS)
    {
        $this->statusCode = $code;

        return $this;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
