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

class DummyValidator extends Validator
{
    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, array $arguments)
    {
    }
}
