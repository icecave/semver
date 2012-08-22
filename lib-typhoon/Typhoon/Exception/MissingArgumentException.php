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

final class MissingArgumentException extends UnexpectedInputException
{
    /**
     * @param string $parameterName
     * @param integer $index
     * @param string $expectedType
     * @param Exception|null $previous
     */
    public function __construct(
        $parameterName,
        $index,
        $expectedType,
        Exception $previous = null
    ) {
        $this->parameterName = $parameterName;
        $this->index = $index;
        $this->expectedType = $expectedType;

        parent::__construct(
            sprintf(
                "Missing argument for parameter '%s' at index %d. Expected '%s'.",
                $this->parameterName(),
                $this->index(),
                $this->expectedType()
            ),
            $previous
        );
    }

    /**
     * @return string
     */
    public function parameterName()
    {
        return $this->parameterName;
    }

    /**
     * @return integer
     */
    public function index()
    {
        return $this->index;
    }

    /**
     * @return string
     */
    public function expectedType()
    {
        return $this->expectedType;
    }

    private $parameterName;
    private $index;
    private $expectedType;
}
