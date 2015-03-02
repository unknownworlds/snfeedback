<?php

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