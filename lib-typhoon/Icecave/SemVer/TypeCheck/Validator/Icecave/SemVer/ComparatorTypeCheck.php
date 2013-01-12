<?php
namespace Icecave\SemVer\TypeCheck\Validator\Icecave\SemVer;


class ComparatorTypeCheck extends \Icecave\SemVer\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function compare(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 2))
        {
            if (($argumentCount < 1))
            {
                throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('left', 0, 'Icecave\\SemVer\\Version'));
            }
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('right', 1, 'Icecave\\SemVer\\Version'));
        }
        elseif (($argumentCount > 2))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]));
        }
    }
    public function compareIdentifierParts(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 2))
        {
            if (($argumentCount < 1))
            {
                throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('left', 0, 'array<string>'));
            }
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('right', 1, 'array<string>'));
        }
        elseif (($argumentCount > 3))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]));
        }
        ($value = $arguments[0]);
        ($check =         function ($value)
                {
                    if ((!\is_array($value)))
                    {
                        return false;
                    }
                    foreach ($value as $key => $subValue)
                    {
                        if ((!\is_string($subValue)))
                        {
                            return false;
                        }
                    }
                    return true;
                }
        );
        if ((!$check($arguments[0])))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'left',
                0,
                $arguments[0],
                'array<string>'
            ));
        }
        ($value = $arguments[1]);
        ($check =         function ($value)
                {
                    if ((!\is_array($value)))
                    {
                        return false;
                    }
                    foreach ($value as $key => $subValue)
                    {
                        if ((!\is_string($subValue)))
                        {
                            return false;
                        }
                    }
                    return true;
                }
        );
        if ((!$check($arguments[1])))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'right',
                1,
                $arguments[1],
                'array<string>'
            ));
        }
        if (($argumentCount > 2))
        {
            ($value = $arguments[2]);
            if ((!\is_bool($value)))
            {
                throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'invertZeroLengthChecks',
                    2,
                    $arguments[2],
                    'boolean'
                ));
            }
        }
    }
    public function compareIdentifierPart(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 2))
        {
            if (($argumentCount < 1))
            {
                throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('left', 0, 'string'));
            }
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('right', 1, 'string'));
        }
        elseif (($argumentCount > 2))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]));
        }
        ($value = $arguments[0]);
        if ((!\is_string($value)))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'left',
                0,
                $arguments[0],
                'string'
            ));
        }
        ($value = $arguments[1]);
        if ((!\is_string($value)))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'right',
                1,
                $arguments[1],
                'string'
            ));
        }
    }
}
