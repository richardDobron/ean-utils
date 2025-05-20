<?php

namespace dobron\EanUtils\Interfaces;

interface ValidatorInterface
{
    public static function validate(string $code): bool;
}
