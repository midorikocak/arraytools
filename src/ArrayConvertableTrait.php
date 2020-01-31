<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

use function lcfirst;
use function preg_match;

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
                $toReturn[$varName] = $this->$methodName();
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
            $constructorArray[] = $data[$paramName] ?? null;
        }

        return $reflection->newInstanceArgs($constructorArray);
    }
}
