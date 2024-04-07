<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class ApiErrorResponse implements Responsable
{
    public function __construct(
        protected Throwable $e,
        protected string $message,
        protected int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        protected array $headers = []
    ) {
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request): JsonResponse
    {
        $response = ['success' => false, 'message' => $this->message];

        if ($this->e && config('app.debug')) {
            $response['debug'] = [
                'message' => $this->e->getMessage(),
                'file' => $this->e->getFile(),
                'line' => $this->e->getLine(),
                'trace' => $this->e->getTrace(),
            ];
        }

        return \response()->json($response, $this->code, $this->headers);
    }
}
