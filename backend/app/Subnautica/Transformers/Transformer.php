<?php

// This file is provided under The MIT License as part of the Subnautica feedback system
// Copyright (c) 2015 Unknown Worlds Entertainment Inc.
// Please see the included LICENSE.txt for additional information.

namespace Subnautica\Transformers;

/**
 * Class Transformer
 * @package Server\Transformers
 */
abstract class Transformer
{

    /**
     * @param array $items
     * @return array
     */
    public function transformArray(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }

    /**
     * @param array $item
     * @return mixed
     */
    public abstract function transform(array $item);

} 