<?php

declare(strict_types=1);

namespace EanGeneratorsTest;

use dobron\EanUtils\Ean13Generator;
use dobron\EanUtils\Ean8Generator;
use dobron\EanUtils\EanValidator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class EanGeneratorsTest extends TestCase
{
    private $gen8;
    private $gen13;

    protected function setUp(): void
    {
        $this->gen8 = new Ean8Generator();
        $this->gen13 = new Ean13Generator();
    }

    public static function generationProvider(): array
    {
        return [
            ['ean8', '1', '', '00000017'],
            ['ean8', '1234', '', '00012348'],
            ['ean8', '9999999', '', '99999995'],
            ['ean8', '0', '', '00000000'],
            ['ean8', '1', '45', '45000010'],
            ['ean8', '123', '01', '01001235'],
            ['ean13', '1', '', '0000000000017'],
            ['ean13', '666066606661', '', '6660666066617'],
            ['ean13', '123456', '', '0000001234565'],
            ['ean13', '98765', '200', '2000000987651'],
            ['ean13', '42', '123', '1230000000420'],
        ];
    }

    /**
     * @dataProvider generationProvider
     */
    public function testGenerateAndValidate(string $type, string $body, string $prefix, string $expected): void
    {
        if ($type === 'ean8') {
            $code = $this->gen8->generate($body, $prefix);
        } else {
            $code = $this->gen13->generate($body, $prefix);
        }

        $this->assertSame($expected, $code);
        $this->assertTrue(EanValidator::validate($code));

        if ($prefix !== '') {
            $this->assertStringStartsWith($prefix, $code);
        }
    }

    public static function invalidProvider(): array
    {
        return [
            ['ean8', '12A3', ''],
            ['ean13', 'ABC', '123'],
            ['ean8', '12345678', ''],
            ['ean13', '1234567891234', ''],
            ['ean8', '1', '1234567'],
            ['ean13', '1', '123456789123'],
        ];
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testInvalidInputs(string $type, string $body, string $prefix): void
    {
        $this->expectException(InvalidArgumentException::class);

        if ($type === 'ean8') {
            $this->gen8->generate($body, $prefix);
        } else {
            $this->gen13->generate($body, $prefix);
        }
    }
}
