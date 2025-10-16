<?php

namespace Lendable\Interview\Application\Rounding;

use Lendable\Interview\Domain\Loan\LoanAmount;
use Lendable\Interview\Domain\Math\Rational;

interface FeeRoundingPolicy
{
    public function round(LoanAmount $amount, Rational $baseFee): int;
}
