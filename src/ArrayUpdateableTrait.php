<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

use function ucfirst;

trait ArrayUpdateableTrait
{
    /**
     * Expects the implemented class to have matching setters with array keys
     */
    public function setFromArray(array $data)
    {
        foreach ($data as $key => $value) {
            $methodName = 'set' . ucfirst($key);
            $this->$methodName($data[$key]);
        }
    }
}
