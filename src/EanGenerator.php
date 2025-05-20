<?php

namespace dobron\EanUtils;

use dobron\EanUtils\Interfaces\GeneratorInterface;
use InvalidArgumentException;

abstract class EanGenerator implements GeneratorInterface
{
    private const SUPPORTED_LENGTHS = [8, 13];

    protected $length;

    public function __construct(int $length)
    {
        if (!in_array($length, self::SUPPORTED_LENGTHS, true)) {
            throw new InvalidArgumentException("Unsupported EAN length: $length");
        }
        $this->length = $length;
    }

    public function generate(string $body, string $prefix = ''): string
    {
        if (!ctype_digit($body) || ($prefix !== '' && !ctype_digit($prefix))) {
            throw new InvalidArgumentException("Body and prefix must be numeric strings.");
        }

        $reamingLength = $this->length - 1 - strlen($prefix);
        if ($reamingLength < 1) {
            throw new InvalidArgumentException("Prefix too long for EAN-{$this->length}.");
        }

        if (strlen($body) > $reamingLength) {
            throw new InvalidArgumentException("Body too long; max {$reamingLength} digits.");
        }

        $body = str_pad($body, $reamingLength, '0', STR_PAD_LEFT);

        $code = $prefix . $body;
        $checksum = EanValidator::calculateChecksum($code, $this->length);

        return $code . $checksum;
    }
}
