<?php

// This file is provided under The MIT License as part of the Subnautica feedback system
// Copyright (c) 2015 Unknown Worlds Entertainment Inc.
// Please see the included LICENSE.txt for additional information.

use Carbon\Carbon;
use Subnautica\Repositories\FeedbackTicketsRepository;
use Subnautica\Transformers\FeedbackTicketsTransformer;
use Subnautica\Validators\ValidationException;

class FeedbackApiController extends BaseApiController
{
    private $repository;

    function __construct(FeedbackTicketsRepository $repository, FeedbackTicketsTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    public function store()
    {
        try {
            $this->repository->create(Input::all());
        } catch (ValidationException $e) {
            return $this->respondValidationFailed($e->getErrors());
        } catch (Exception $e) {
            return $this->setStatusCode(500)->respondWithError('An error occurred. Wow. Such help. [' . $e->getMessage() . ']');
        }

        return $this->respondCreated('Feedback ticket submited. Thanks!');
    }

    public function index()
    {
        return Cache::remember('api.feedbackTickets', 15, function () {
            return $this->repository->filteredData(Input::all());
        });
    }

    public function show($id)
    {
        return $this->respond($this->repository->find($id));
    }
}