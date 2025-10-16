<?php

namespace Lendable\Interview\Application\Rounding;

use Lendable\Interview\Domain\Loan\LoanAmount;
use Lendable\Interview\Domain\Math\Rational;

final class NearestFivePoundsRoundingPolicy implements FeeRoundingPolicy
{
    private const MULTIPLE_IN_PENNIES = 500;

    public function round(LoanAmount $amount, Rational $baseFee): int
    {
        $loanValue = $amount->toRational();
        $total = $loanValue->add($baseFee);

        $roundedTotal = $total->ceilToNearestMultiple(self::MULTIPLE_IN_PENNIES);

        return $roundedTotal - $amount->toPennies();
    }
}
