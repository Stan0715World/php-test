<?php

namespace Lendable\Interview\Domain\ValueObject;

use PHPUnit\Framework\TestCase;

final class MoneyTest extends TestCase
{
    public function testFormatsWithThousandsSeparator(): void
    {
        $money = Money::fromPennies(123456);

        self::assertSame('1,234.56', $money->format());
    }
}
