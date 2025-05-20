<?php

namespace dobron\EanUtils;

final class Ean13Generator extends EanGenerator
{
    public function __construct()
    {
        parent::__construct(13);
    }
}
