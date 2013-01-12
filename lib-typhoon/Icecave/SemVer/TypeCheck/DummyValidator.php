<?php
namespace Icecave\SemVer\TypeCheck;


class DummyValidator extends AbstractValidator
{
    public function __call($name, array $arguments)
    {
    }
}
