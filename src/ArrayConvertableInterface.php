<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

interface ArrayConvertableInterface
{
    public function toArray(): array;

    public static function fromArray(array $array);
}
