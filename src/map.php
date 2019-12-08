<?php

declare(strict_types = 1);

namespace Lambdish\Phunctional;

use ArgumentCountError;
use Traversable;

/**
 * Returns an array containing the results of applying $fn to the items of the $coll
 *
 * Similar to `array_map` but accepting Traversable.
 * Function $fn should accept the value of the item as the first argument and optionally the key of the
 * item as the second argument.
 *
 * @param callable $fn   function to apply to every item in the collection
 * @param iterable $coll collection of values to apply the function
 */
function map(callable $fn, iterable $coll): array
{
    $args = $coll instanceof Traversable ? iterator_to_array($coll) : $coll;

    try {
        return array_map($fn, $args);
    } catch (ArgumentCountError $error) {
        return ___map_indexed($fn, $args);
    }
}

const map = '\Lambdish\Phunctional\map';

function ___map_indexed(callable $fn, iterable $coll): array
{
    $result = [];

    foreach ($coll as $key => $value) {
        $result[$key] = $fn($value, $key);
    }

    return $result;
}
