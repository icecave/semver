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

use Eloquent\Typhoon\Generator\ValidatorClassGenerator;
use ReflectionClass;

abstract class Typhoon
{
    /**
     * @param string $className
     * @param array<integer,mixed> $arguments
     *
     * @return object
     */
    public static function get($className, array $arguments = null)
    {
        if (static::$dummyMode) {
            return new DummyValidator;
        }

        if (!array_key_exists($className, static::$instances)) {
            static::install(
                $className,
                static::createValidator($className)
            );
        }

        $validator = static::$instances[$className];
        if (null !== $arguments) {
            $validator->validateConstruct($arguments);
        }

        return $validator;
    }

    /**
     * @param boolean $runtimeGeneration
     */
    public static function setRuntimeGeneration($runtimeGeneration)
    {
        static::$runtimeGeneration = $runtimeGeneration;
    }

    /**
     * @return boolean
     */
    public static function runtimeGeneration()
    {
        return static::$runtimeGeneration;
    }

    /**
     * @param string $className
     * @param object $validator
     */
    public static function install($className, $validator)
    {
        static::$instances[$className] = $validator;
    }

    /**
     * @param string $className
     */
    protected static function createValidator($className)
    {
        $validatorClassName = 'Typhoon\\'.$className.'Typhoon';
        if (
            static::$runtimeGeneration &&
            !class_exists($validatorClassName, false)
        ) {
            static::$dummyMode = true;
            static::defineValidator($className);
            static::$dummyMode = false;
        }

        return new $validatorClassName;
    }

    /**
     * @param string $className
     * @param ValidatorClassGenerator|null $classGenerator
     */
    protected static function defineValidator(
        $className,
        ValidatorClassGenerator $classGenerator = null
    ) {
        if (null === $classGenerator) {
            $classGenerator = new ValidatorClassGenerator;
        }

        eval('?>'.$classGenerator->generateFromClass(
            new ReflectionClass($className)
        ));
    }

    private static $instances = array();
    private static $dummyMode = false;
    private static $runtimeGeneration = false;
}
