<?php

namespace Lendable\Interview\Domain\Loan;

use InvalidArgumentException;

enum LoanTerm: int
{
    case TwelveMonths = 12;
    case TwentyFourMonths = 24;

    public static function fromString(string $value): self
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            throw new InvalidArgumentException('Loan term must not be empty.');
        }

        if (!ctype_digit($trimmed)) {
            throw new InvalidArgumentException('Loan term must be an integer number of months.');
        }

        $months = (int) $trimmed;

        return match ($months) {
            12 => self::TwelveMonths,
            24 => self::TwentyFourMonths,
            default => throw new InvalidArgumentException('Loan term must be either 12 or 24 months.'),
        };
    }
}
