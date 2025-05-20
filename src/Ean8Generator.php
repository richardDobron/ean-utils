<?php

namespace dobron\EanUtils;

final class Ean8Generator extends EanGenerator
{
    public function __construct()
    {
        parent::__construct(8);
    }
}
