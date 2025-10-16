<?php

namespace Lendable\Interview\Domain\Loan;

use InvalidArgumentException;
use Lendable\Interview\Domain\Math\Rational;
use Lendable\Interview\Domain\ValueObject\Money;
use Lendable\Interview\Domain\ValueObject\MoneyParser;

final class LoanAmount
{
    private const MIN_PENNIES = 1000_00;
    private const MAX_PENNIES = 2000_000;

    private int $pennies;

    private function __construct(int $pennies)
    {
        $this->pennies = $pennies;
    }

    public static function fromString(string $value): self
    {
        $pennies = MoneyParser::parseToPennies($value);

        if ($pennies < self::MIN_PENNIES || $pennies > self::MAX_PENNIES) {
            throw new InvalidArgumentException('Loan amount must be between 1,000.00 and 20,000.00 inclusive.');
        }

        return new self($pennies);
    }

    public function toPennies(): int
    {
        return $this->pennies;
    }

    public function toMoney(): Money
    {
        return Money::fromPennies($this->pennies);
    }

    public function toRational(): Rational
    {
        return Rational::fromInt($this->pennies);
    }
}
