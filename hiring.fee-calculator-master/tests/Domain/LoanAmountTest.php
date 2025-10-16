<?php

namespace Lendable\Interview\Domain\Loan;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class LoanAmountTest extends TestCase
{
    public function testRejectsAmountBelowMinimum(): void
    {
        $this->expectException(InvalidArgumentException::class);
        LoanAmount::fromString('999.99');
    }

    public function testRejectsAmountAboveMaximum(): void
    {
        $this->expectException(InvalidArgumentException::class);
        LoanAmount::fromString('20,000.01');
    }
}
