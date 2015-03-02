<?php

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