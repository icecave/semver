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

use BadMethodCallException;
use ReflectionObject;

class Validator
{
    public function __construct()
    {
        $this->reflector = new ReflectionObject($this);
    }

    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, array $arguments)
    {
        $validatorMethodName = sprintf(
            'validate%s',
            ucfirst(ltrim($name, '_'))
        );

        if (!$this->reflector->hasMethod($validatorMethodName)) {
            throw new BadMethodCallException(sprintf(
                'Call to undefined method %s::%s().',
                __CLASS__,
                $name
            ));
        }

        return $this->reflector
            ->getMethod($validatorMethodName)
            ->invokeArgs($this, $arguments)
        ;
    }

    private $reflector;
}
