<?php

// This file is provided under The MIT License as part of the Subnautica feedback system
// Copyright (c) 2015 Unknown Worlds Entertainment Inc.
// Please see the included LICENSE.txt for additional information.

use Illuminate\Http\Response as IlluminateResponse;

/**
 * Class BaseApiController
 */
class BaseApiController extends Controller
{
    /**
     * @var int
     */
    protected $statusCode = IlluminateResponse::HTTP_OK;
    public $input;

    public function __construct($statusCode)
    {
        $this->input = $this->getInput();

        $this->statusCode = $statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        $json = json_decode(file_get_contents('php://input'));

        if ($json !== null) {
            return $json;
        } else {
            return json_decode(json_encode(Input::all()));
        }
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Item not found!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal error!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondValidationFailed($message = 'Parameters failed validation!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'statusCode' => $this->getStatusCode()
            ]
        ]);

    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondCreated($message = 'Item created!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respond([
            'message' => $message
        ]);
    }

    /**
     * @param Paginator $elements
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithPagination(Paginator $elements, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'totalCount' => $elements->getTotal(),
                'totalPages' => ceil($elements->getTotal() / $elements->getPerPage()),
                'currentPage' => $elements->getCurrentPage(),
                'limit' => $elements->getPerPage()
            ]
        ]);

        return $this->respond($data);
    }
}