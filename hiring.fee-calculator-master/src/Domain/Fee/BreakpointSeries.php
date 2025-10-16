<?php

namespace Lendable\Interview\Domain\Fee;

use InvalidArgumentException;
use Lendable\Interview\Domain\Loan\LoanAmount;
use Lendable\Interview\Domain\Math\Rational;

final class BreakpointSeries
{
    /** @var Breakpoint[] */
    private array $points;

    /**
     * @param Breakpoint[] $points
     */
    public function __construct(array $points)
    {
        if (count($points) < 2) {
            throw new InvalidArgumentException('A breakpoint series requires at least two points.');
        }

        usort($points, static fn (Breakpoint $a, Breakpoint $b) => $a->amount() <=> $b->amount());

        $this->points = array_values($points);
    }

    public static function fromArray(array $points): self
    {
        $breakpoints = [];

        foreach ($points as $amount => $fee) {
            $breakpoints[] = new Breakpoint((int) $amount * 100, (int) $fee * 100);
        }

        return new self($breakpoints);
    }

    public function interpolate(LoanAmount $amount): Rational
    {
        $value = $amount->toPennies();
        $previous = null;

        foreach ($this->points as $point) {
            if ($value === $point->amount()) {
                return Rational::fromInt($point->fee());
            }

            if ($value < $point->amount()) {
                if ($previous === null) {
                    throw new InvalidArgumentException('Loan amount falls below the configured breakpoints.');
                }

                return $this->interpolateBetween($previous, $point, $value);
            }

            $previous = $point;
        }

        if ($previous === null) {
            throw new InvalidArgumentException('No breakpoints configured.');
        }

        if ($value > $previous->amount()) {
            throw new InvalidArgumentException('Loan amount exceeds the configured breakpoints.');
        }

        return Rational::fromInt($previous->fee());
    }

    private function interpolateBetween(Breakpoint $lower, Breakpoint $upper, int $value): Rational
    {
        $amountSpacing = $upper->amount() - $lower->amount();
        $amountOffset = $value - $lower->amount();
        $feeSpacing = $upper->fee() - $lower->fee();

        $ratio = Rational::fromFraction($amountOffset, $amountSpacing);
        $increment = $ratio->multiplyByInt($feeSpacing);

        return Rational::fromInt($lower->fee())->add($increment);
    }
}
