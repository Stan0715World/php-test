<?php

namespace Lendable\Interview\Domain\Math;

final class Rational
{
    private int $numerator;
    private int $denominator;

    private function __construct(int $numerator, int $denominator)
    {
        if ($denominator === 0) {
            throw new \InvalidArgumentException('Denominator cannot be zero.');
        }

        if ($denominator < 0) {
            $numerator *= -1;
            $denominator *= -1;
        }

        $gcd = self::gcd(abs($numerator), $denominator);

        $this->numerator = intdiv($numerator, $gcd);
        $this->denominator = intdiv($denominator, $gcd);
    }

    public static function fromInt(int $value): self
    {
        return new self($value, 1);
    }

    public static function fromFraction(int $numerator, int $denominator): self
    {
        return new self($numerator, $denominator);
    }

    public function add(self $other): self
    {
        $numerator = $this->numerator * $other->denominator + $other->numerator * $this->denominator;
        $denominator = $this->denominator * $other->denominator;

        return new self($numerator, $denominator);
    }

    public function multiplyByInt(int $factor): self
    {
        return new self($this->numerator * $factor, $this->denominator);
    }

    public function numerator(): int
    {
        return $this->numerator;
    }

    public function denominator(): int
    {
        return $this->denominator;
    }

    public function ceilToNearestMultiple(int $multiple): int
    {
        if ($multiple <= 0) {
            throw new \InvalidArgumentException('Multiple must be greater than zero.');
        }

        $multipliedDenominator = $this->denominator * $multiple;
        $adjustedNumerator = $this->numerator;

        $quotient = intdiv($adjustedNumerator + $multipliedDenominator - 1, $multipliedDenominator);

        return $quotient * $multiple;
    }

    private static function gcd(int $a, int $b): int
    {
        while ($b !== 0) {
            $tmp = $a % $b;
            $a = $b;
            $b = $tmp;
        }

        return $a === 0 ? 1 : $a;
    }
}
