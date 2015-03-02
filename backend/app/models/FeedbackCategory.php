<?php

// This file is provided under The MIT License as part of the Subnautica feedback system
// Copyright (c) 2015 Unknown Worlds Entertainment Inc.
// Please see the included LICENSE.txt for additional information.

class FeedbackCategory extends \Eloquent {
	protected $fillable = ['name'];
    protected $hidden = ['pivot'];

    public function tickets()
    {
        return $this->belongsToMany('FeedbackTicket', 'feedback_pivot');
    }
}