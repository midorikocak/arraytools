<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

use function is_array;
use function is_object;
use function lcfirst;
use function preg_match;
use function preg_replace;
use function strtolower;

trait ArrayConvertableTrait
{
    /**
     * Expects that implemented class has getters matching array keys.
     *
     * @throws ReflectionException
     */
    public function toArray(): array
    {
        $toReturn = [];
        $reflection = new ReflectionClass(static::class);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            $methodName = $method->getName();
            $isGetter = preg_match('~get([A-Z].+)~', $methodName, $matches);
            if ($isGetter) {
                $varName = lcfirst($matches[1]);
                $varValue = $this->$methodName();
                if (is_array($varValue)) {
                    foreach ($varValue as &$value) {
                        if (is_object($value)) {
                            $value = $value->toArray();
                        }
                    }
                }
                $toReturn[self::makeKebab($varName)] = $varValue;
            }
        }
        return $toReturn;
    }

    /**
     * Expects the implemented class has proper constructor parameters matching array keys.
     *
     * @return mixed
     * @throws ReflectionException
     */
    public static function fromArray(array $data)
    {
        $constructorArray = [];
        $reflection = new ReflectionClass(static::class);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        foreach ($params as $param) {
            $paramName = $param->getName();
            $constructorArray[] = $data[self::makeKebab($paramName)] ?? null;
        }

        return $reflection->newInstanceArgs($constructorArray);
    }

    private static function makeKebab($camel): string
    {
        return strtolower(preg_replace('%([A-Z])([a-z])%', '_\1\2', $camel));
    }
}
