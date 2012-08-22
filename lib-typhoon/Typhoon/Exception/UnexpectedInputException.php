<?php

/*
 * This file is part of the Typhoon package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Typhoon\Exception;

use Exception;
use InvalidArgumentException;

abstract class UnexpectedInputException extends InvalidArgumentException
{
    /**
     * @param string $message
     * @param Exception|null $previous
     */
    public function __construct($message, Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
