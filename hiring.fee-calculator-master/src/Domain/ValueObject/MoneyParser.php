<?php

namespace Lendable\Interview\Domain\ValueObject;

use InvalidArgumentException;

final class MoneyParser
{
    public static function parseToPennies(string $value): int
    {
        $normalized = str_replace(',', '', trim($value));

        if ($normalized === '') {
            throw new InvalidArgumentException('Amount must not be empty.');
        }

        if ($normalized[0] === '+') {
            $normalized = substr($normalized, 1);
        }

        if (!preg_match('/^\d+(?:\.\d{1,2})?$/', $normalized)) {
            throw new InvalidArgumentException('Amount must be a numeric value with up to two decimal places.');
        }

        [$pounds, $fraction] = array_pad(explode('.', $normalized, 2), 2, '0');

        if ($fraction !== '' && strlen($fraction) > 2) {
            throw new InvalidArgumentException('Amount must not have more than two decimal places.');
        }

        $fraction = str_pad($fraction, 2, '0');

        $pennies = (int) $pounds * 100 + (int) $fraction;

        return $pennies;
    }
}
