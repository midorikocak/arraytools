<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

abstract class AbstractValidator implements ValidableInterface
{
    protected array $validators = [];
    protected bool $isValid = true;

    public function uValidate($toValidate, callable $fn): bool
    {
        return $this->validate($toValidate) && $fn($toValidate);
    }

    public function validate($toValidate): bool
    {
        foreach ($this->validators as $validatorFn) {
            $this->isValid = $this->isValid && $validatorFn($toValidate);
        }

        $toReturn = $this->isValid;

        // Reset isValid property
        $this->isValid = true;
        return $toReturn;
    }
}
