<?php

// This file is provided under The MIT License as part of the Subnautica feedback system
// Copyright (c) 2015 Unknown Worlds Entertainment Inc.
// Please see the included LICENSE.txt for additional information.

class FeedbackTicket extends Eloquent {
	protected $fillable = [
        'unique_id', 'ip', 'cpu', 'gpu', 'ram', 'os', 'position_x', 'position_y', 'position_z', 'orientation_w',
        'orientation_x', 'orientation_z', 'mean_frame_time_30', 'emotion', 'text', 'screenshot', 'csid', 'email'
    ];

    protected $hidden = ['email'];

    public function categories()
    {
        return $this->belongsToMany('FeedbackCategory', 'feedback_pivot')->select(['name']);
    }
}