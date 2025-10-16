<?php

namespace Lendable\Interview\Domain\ValueObject;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MoneyParserTest extends TestCase
{
    public function testParsesCommaSeparatedInput(): void
    {
        self::assertSame(1150000, MoneyParser::parseToPennies('11,500'));
    }

    public function testRejectsMoreThanTwoDecimalPlaces(): void
    {
        $this->expectException(InvalidArgumentException::class);
        MoneyParser::parseToPennies('10.123');
    }
}
