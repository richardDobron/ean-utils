<?php

namespace dobron\EanUtils;

use dobron\EanUtils\Interfaces\ValidatorInterface;

final class EanValidator implements ValidatorInterface
{
    private const SUPPORTED_LENGTHS = [8, 13];

    public static function validate(string $code): bool
    {
        if (!ctype_digit($code)) {
            return false;
        }

        $len = strlen($code);
        if (!in_array($len, self::SUPPORTED_LENGTHS, true)) {
            return false;
        }

        $body = substr($code, 0, -1);
        $checksum = (int)$code[-1];

        return $checksum === self::calculateChecksum($body, $len);
    }

    public static function calculateChecksum(string $body, int $length): int
    {
        $sum = 0;
        foreach (str_split($body) as $index => $digit) {
            $n = (int)$digit;
            $isEven = $index % 2 === 0;
            if ($length === 13) {
                $sum += $isEven ? $n : $n * 3;
            } else {
                $sum += $isEven ? $n * 3 : $n;
            }
        }

        return (10 - ($sum % 10)) % 10;
    }
}
