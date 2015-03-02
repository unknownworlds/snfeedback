<?php

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