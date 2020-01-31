<?php

declare(strict_types=1);

namespace midorikocak\arraytools;

interface ArrayUpdateableInterface
{
    public function setFromArray(array $data);
}
