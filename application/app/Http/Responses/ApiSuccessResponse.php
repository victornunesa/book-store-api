<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ApiSuccessResponse implements Responsable
{
    public function __construct(
        protected mixed $data,
        protected string $message = '',
        protected array $metaData = [],
        protected int $code = Response::HTTP_OK,
        protected array $headers = []
    ) {
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return response()->json([
            'success' => true,
            'data' => $this->data,
            'message' => $this->message,
            'metadata' => $this->metaData,
        ], $this->code, $this->headers);
    }
}
