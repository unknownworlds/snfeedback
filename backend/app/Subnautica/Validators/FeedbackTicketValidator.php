<?php

// This file is provided under The MIT License as part of the Subnautica feedback system
// Copyright (c) 2015 Unknown Worlds Entertainment Inc.
// Please see the included LICENSE.txt for additional information.

namespace Subnautica\Validators;


class TicketValidator extends Validator
{

    /**
     * Rules for a support ticket
     *
     * @var array
     */
    protected static $rules = [
        'unique_id'  => 'required',
        'ram'        => 'integer',
        //'text'       => 'required',
        'emotion'    => 'required|integer',
        'position_x' => 'required',
        'position_y' => 'required',
        'position_z' => 'required'
    ];

}