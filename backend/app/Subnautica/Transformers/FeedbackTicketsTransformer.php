<?php

// This file is provided under The MIT License as part of the Subnautica feedback system
// Copyright (c) 2015 Unknown Worlds Entertainment Inc.
// Please see the included LICENSE.txt for additional information.

namespace Subnautica\Transformers;

class FeedbackTicketsTransformer extends Transformer {

	public function transform( array $tickets ) {
		foreach ( $tickets as $key => $value ) {

			$categories = array_map(function($item) {
				return $item['name'];
			}, $tickets[$key]['categories']);

			$tickets[$key]['categories'] = join(', ', $categories);
		}

		return $tickets;
	}

} 