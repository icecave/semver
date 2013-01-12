<?php
namespace Icecave\SemVer\TypeCheck\Validator\Icecave\SemVer;


class VersionTypeCheck extends \Icecave\SemVer\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount > 5))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(5, $arguments[5]));
        }
        if (($argumentCount > 0))
        {
            ($value = $arguments[0]);
            if ((!\is_int($value)))
            {
                throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'major',
                    0,
                    $arguments[0],
                    'integer'
                ));
            }
        }
        if (($argumentCount > 1))
        {
            ($value = $arguments[1]);
            if ((!\is_int($value)))
            {
                throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'minor',
                    1,
                    $arguments[1],
                    'integer'
                ));
            }
        }
        if (($argumentCount > 2))
        {
            ($value = $arguments[2]);
            if ((!\is_int($value)))
            {
                throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'patch',
                    2,
                    $arguments[2],
                    'integer'
                ));
            }
        }
        if (($argumentCount > 3))
        {
            ($value = $arguments[3]);
            if ((!(\is_string($value) || ($value === null))))
            {
                throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'preReleaseIdentifier',
                    3,
                    $arguments[3],
                    'string|null'
                ));
            }
        }
        if (($argumentCount > 4))
        {
            ($value = $arguments[4]);
            if ((!(\is_string($value) || ($value === null))))
            {
                throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'buildIdentifier',
                    4,
                    $arguments[4],
                    'string|null'
                ));
            }
        }
    }
    public function parse(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('version', 0, 'string'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        ($value = $arguments[0]);
        if ((!\is_string($value)))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'version',
                0,
                $arguments[0],
                'string'
            ));
        }
    }
    public function tryParse(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('version', 0, 'string'));
        }
        elseif (($argumentCount > 2))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]));
        }
        ($value = $arguments[0]);
        if ((!\is_string($value)))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'version',
                0,
                $arguments[0],
                'string'
            ));
        }
    }
    public function isValid(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('version', 0, 'string'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        ($value = $arguments[0]);
        if ((!\is_string($value)))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'version',
                0,
                $arguments[0],
                'string'
            ));
        }
    }
    public function adapt(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('version', 0, 'Icecave\\SemVer\\Version|string'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        ($value = $arguments[0]);
        if ((!(($value instanceof \Icecave\SemVer\Version) || \is_string($value))))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'version',
                0,
                $arguments[0],
                'Icecave\\SemVer\\Version|string'
            ));
        }
    }
    public function major(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function setMajor(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('major', 0, 'integer'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        ($value = $arguments[0]);
        if ((!\is_int($value)))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'major',
                0,
                $arguments[0],
                'integer'
            ));
        }
    }
    public function minor(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function setMinor(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('minor', 0, 'integer'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        ($value = $arguments[0]);
        if ((!\is_int($value)))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'minor',
                0,
                $arguments[0],
                'integer'
            ));
        }
    }
    public function patch(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function setPatch(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('patch', 0, 'integer'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        ($value = $arguments[0]);
        if ((!\is_int($value)))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'patch',
                0,
                $arguments[0],
                'integer'
            ));
        }
    }
    public function preReleaseIdentifier(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function preReleaseIdentifierParts(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function setPreReleaseIdentifier(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('preReleaseIdentifier', 0, 'string|null'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        ($value = $arguments[0]);
        if ((!(\is_string($value) || ($value === null))))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'preReleaseIdentifier',
                0,
                $arguments[0],
                'string|null'
            ));
        }
    }
    public function buildIdentifier(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function buildIdentifierParts(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function setBuildIdentifier(array $arguments)
    {
        ($argumentCount = \count($arguments));
        if (($argumentCount < 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\MissingArgumentException('buildIdentifier', 0, 'string|null'));
        }
        elseif (($argumentCount > 1))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]));
        }
        ($value = $arguments[0]);
        if ((!(\is_string($value) || ($value === null))))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentValueException(
                'buildIdentifier',
                0,
                $arguments[0],
                'string|null'
            ));
        }
    }
    public function isStable(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function string(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
    public function validateToString(array $arguments)
    {
        if ((\count($arguments) > 0))
        {
            throw (new \Icecave\SemVer\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]));
        }
    }
}
