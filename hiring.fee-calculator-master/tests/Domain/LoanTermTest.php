<?php

namespace Lendable\Interview\Domain\Loan;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class LoanTermTest extends TestCase
{
    public function testRejectsUnsupportedTerm(): void
    {
        $this->expectException(InvalidArgumentException::class);
        LoanTerm::fromString('18');
    }
}
