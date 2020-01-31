<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

use function array_key_exists;
use function array_keys;
use function filter_var;
use function is_numeric;
use function is_string;
use function sort;

use const FILTER_VALIDATE_BOOLEAN;
use const FILTER_VALIDATE_DOMAIN;
use const FILTER_VALIDATE_EMAIL;
use const FILTER_VALIDATE_FLOAT;
use const FILTER_VALIDATE_INT;
use const FILTER_VALIDATE_MAC;
use const FILTER_VALIDATE_REGEXP;

class ArrayValidator extends AbstractValidator
{
    private array $schema = [];
    private array $keys = [];

    public function notEmpty(...$keys): self
    {
        $this->validators[] = static function (array $array) use ($keys) {
            foreach ($keys as $key) {
                if (empty($array[$key])) {
                    return false;
                }
            }
            return true;
        };

        return $this;
    }

    public function keys(...$keys): self
    {
        $this->validators[] = static function (array $array) use ($keys) {
            $keysToValidate = array_keys($array);

            sort($keys);
            sort($keysToValidate);

            return $keys === $keysToValidate;
        };

        return $this;
    }

    public function hasKeys(...$keys): self
    {
        $this->validators[] = static function (array $array) use ($keys) {
            foreach ($keys as $keyToCheck) {
                if (!array_key_exists($keyToCheck, $array)) {
                    return false;
                }
            }
            return true;
        };

        return $this;
    }

    public function key($key): self
    {
        $this->validators[] = static function (array $array) use ($key) {
            return array_key_exists($key, $array);
        };

        return $this;
    }

    public function hasKey($key): self
    {
        $this->validators[] = static function (array $array) use ($key) {
            return array_key_exists($key, $array);
        };

        return $this;
    }

    public function schema(array $schema): self
    {
        $this->schema = $schema;
        $this->keys = array_keys($schema);

        $this->validators[] = static function (array $array) use ($schema) {
            foreach ($schema as $key => $filter) {
                if ($filter === 'boolean' && filter_var($array[$key], FILTER_VALIDATE_BOOLEAN)) {
                    continue;
                }

                if ($filter === 'domain' && filter_var($array[$key], FILTER_VALIDATE_DOMAIN)) {
                    continue;
                }

                if ($filter === 'int' && filter_var($array[$key], FILTER_VALIDATE_INT)) {
                    continue;
                }

                if ($filter === 'email' && filter_var($array[$key], FILTER_VALIDATE_EMAIL)) {
                    continue;
                }

                if ($filter === 'mac' && filter_var($array[$key], FILTER_VALIDATE_MAC)) {
                    continue;
                }

                if ($filter === 'float' && filter_var($array[$key], FILTER_VALIDATE_FLOAT)) {
                    continue;
                }

                if ($filter === 'regexp' && filter_var($array[$key], FILTER_VALIDATE_REGEXP)) {
                    continue;
                }

                if ($filter === 'string' && is_string($array[$key])) {
                    continue;
                }

                if ($filter === 'numeric' && is_numeric($array[$key])) {
                    continue;
                }

                return false;
            }
            return true;
        };

        return $this;
    }
}
