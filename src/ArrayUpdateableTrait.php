<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

use function str_replace;
use function ucfirst;
use function ucwords;

trait ArrayUpdateableTrait
{
    /**
     * Expects the implemented class to have matching setters with array keys
     */
    public function setFromArray(array $data)
    {
        foreach ($data as $key => $value) {
            $str = str_replace('_', '', ucwords($key, '_'));
            $methodName = 'set' . ucfirst($str);
            $this->$methodName($data[$key]);
        }
    }
}
