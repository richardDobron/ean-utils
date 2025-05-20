<?php

namespace dobron\EanUtils\Interfaces;

interface GeneratorInterface
{
    public function generate(string $body, string $prefix = ''): string;
}
