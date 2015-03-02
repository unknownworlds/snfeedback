<?php

class FeedbackCategory extends \Eloquent {
	protected $fillable = ['name'];
    protected $hidden = ['pivot'];

    public function tickets()
    {
        return $this->belongsToMany('FeedbackTicket', 'feedback_pivot');
    }
}