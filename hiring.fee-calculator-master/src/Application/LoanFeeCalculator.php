<?php

namespace Lendable\Interview\Application;

use Lendable\Interview\Application\Rounding\FeeRoundingPolicy;
use Lendable\Interview\Domain\Fee\FeeStructure;
use Lendable\Interview\Domain\Loan\LoanAmount;
use Lendable\Interview\Domain\Loan\LoanTerm;
use Lendable\Interview\Domain\ValueObject\Money;

final class LoanFeeCalculator
{
    private FeeStructure $feeStructure;
    private FeeRoundingPolicy $roundingPolicy;

    public function __construct(FeeStructure $feeStructure, FeeRoundingPolicy $roundingPolicy)
    {
        $this->feeStructure = $feeStructure;
        $this->roundingPolicy = $roundingPolicy;
    }

    public function calculate(LoanAmount $amount, LoanTerm $term): Money
    {
        $series = $this->feeStructure->forTerm($term);
        $baseFee = $series->interpolate($amount);
        $feePennies = $this->roundingPolicy->round($amount, $baseFee);

        return Money::fromPennies($feePennies);
    }
}
