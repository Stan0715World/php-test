<?php

namespace Lendable\Interview\Application;

use Lendable\Interview\Application\Rounding\NearestFivePoundsRoundingPolicy;
use Lendable\Interview\Domain\Fee\ConfigurationFeeStructure;
use Lendable\Interview\Domain\Loan\LoanAmount;
use Lendable\Interview\Domain\Loan\LoanTerm;
use PHPUnit\Framework\TestCase;

final class LoanFeeCalculatorTest extends TestCase
{
    public function testCalculatesFeeForTwentyFourMonthExample(): void
    {
        $calculator = $this->createCalculator();

        $fee = $calculator->calculate(
            LoanAmount::fromString('11,500.00'),
            LoanTerm::fromString('24')
        );

        self::assertSame('460.00', $fee->format());
    }

    public function testCalculatesFeeForTwelveMonthExample(): void
    {
        $calculator = $this->createCalculator();

        $fee = $calculator->calculate(
            LoanAmount::fromString('19,250.00'),
            LoanTerm::fromString('12')
        );

        self::assertSame('385.00', $fee->format());
    }

    public function testFeeIsRoundedUpToFivePoundMultiple(): void
    {
        $calculator = $this->createCalculator();

        $fee = $calculator->calculate(
            LoanAmount::fromString('11,575.75'),
            LoanTerm::fromString('24')
        );

        self::assertSame('464.25', $fee->format());
    }

    private function createCalculator(): LoanFeeCalculator
    {
        return new LoanFeeCalculator(
            ConfigurationFeeStructure::withDefaults(),
            new NearestFivePoundsRoundingPolicy()
        );
    }
}
