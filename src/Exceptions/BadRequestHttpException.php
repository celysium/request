<?php

namespace Celysium\Request\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseClass;
use Celysium\Responser\Responser;
use Throwable;

class BadRequestHttpException extends Exception
{
    public function __construct(public Response $response, $message = "", $code = ResponseClass::HTTP_BAD_REQUEST, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        $response = $this->response->json();
        return Responser::error($response['data'], $response['messages'], $this->response->status(), $response['meta']);
    }

}
