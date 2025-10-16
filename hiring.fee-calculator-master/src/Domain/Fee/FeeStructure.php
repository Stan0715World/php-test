<?php

namespace Lendable\Interview\Domain\Fee;

use Lendable\Interview\Domain\Loan\LoanTerm;

interface FeeStructure
{
    public function forTerm(LoanTerm $term): BreakpointSeries;
}
