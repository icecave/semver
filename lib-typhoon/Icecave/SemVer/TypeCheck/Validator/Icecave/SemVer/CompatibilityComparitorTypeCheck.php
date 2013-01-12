<?php
namespace Icecave\SemVer\TypeCheck\Validator\Icecave\SemVer;


class CompatibilityComparitorTypeCheck extends \Icecave\SemVer\TypeCheck\AbstractValidator
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
}
