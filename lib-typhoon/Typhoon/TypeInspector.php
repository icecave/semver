<?php

/*
 * This file is part of the Typhoon package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Typhoon;

use ReflectionObject;
use Traversable;

class TypeInspector
{
    /**
     * @param mixed $value
     * @param integer $maxIterations
     *
     * @return string
     */
    public function type($value, $maxIterations = 10)
    {
        $nativeType = gettype($value);
        if ('array' === $nativeType) {
            return $this->arrayType($value, $maxIterations);
        }
        if ('double' === $nativeType) {
            return 'float';
        }
        if ('NULL' === $nativeType) {
            return 'null';
        }
        if ('object' === $nativeType) {
            return $this->objectType($value, $maxIterations);
        }
        if ('resource' === $nativeType) {
            return $this->resourceType($value);
        }

        return $nativeType;
    }

    /**
     * @param array $value
     * @param integer $maxIterations
     *
     * @return string
     */
    protected function arrayType(array $value, $maxIterations)
    {
        return 'array'.$this->traversableSubTypes($value, $maxIterations);
    }

    /**
     * @param object $value
     * @param integer $maxIterations
     *
     * @return string
     */
    protected function objectType($value, $maxIterations)
    {
        $reflector = new ReflectionObject($value);
        $class = $reflector->getName();

        $traversableSubTypes = '';
        if ($value instanceof Traversable) {
            $traversableSubTypes = $this->traversableSubTypes($value, $maxIterations);
        }

        return $class.$traversableSubTypes;
    }

    /**
     * @param array|object $value
     * @param integer $maxIterations
     *
     * @return string
     */
    protected function traversableSubTypes($value, $maxIterations)
    {
        $keyTypes = array();
        $valueTypes = array();
        $i = 0;
        foreach ($value as $key => $subValue) {
            $keyTypes[] = $this->type($key);
            $valueTypes[] = $this->type($subValue);

            $i ++;
            if ($i >= $maxIterations) {
                break;
            }
        }

        if (count($valueTypes) < 1) {
            return '';
        }

        $keyTypes = array_unique($keyTypes);
        sort($keyTypes, SORT_STRING);

        $valueTypes = array_unique($valueTypes);
        sort($valueTypes, SORT_STRING);

        return sprintf(
            '<%s, %s>',
            implode('|', $keyTypes),
            implode('|', $valueTypes)
        );
    }

    /**
     * @param resource $value
     *
     * @return string
     */
    protected function resourceType($value)
    {
        $ofType = get_resource_type($value);
        if ('stream' === $ofType) {
            return $this->streamType($value);
        }

        return sprintf(
            'resource {ofType: %s}',
            $ofType
        );
    }

    /**
     * @param stream $value
     *
     * @return string
     */
    protected function streamType($value)
    {
        $metaData = stream_get_meta_data($value);

        return sprintf(
            'stream {readable: %s, writable: %s}',
            preg_match('/[r+]/', $metaData['mode']) ? 'true' : 'false',
            preg_match('/[waxc+]/', $metaData['mode']) ? 'true' : 'false'
        );
    }
}
