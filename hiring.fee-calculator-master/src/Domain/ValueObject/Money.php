<?php

namespace Lendable\Interview\Domain\ValueObject;

final class Money
{
    private int $pennies;

    private function __construct(int $pennies)
    {
        $this->pennies = $pennies;
    }

    public static function fromPennies(int $pennies): self
    {
        return new self($pennies);
    }

    public function toPennies(): int
    {
        return $this->pennies;
    }

    public function format(): string
    {
        $whole = intdiv($this->pennies, 100);
        $fraction = $this->pennies % 100;

        if ($fraction < 0) {
            $fraction += 100;
            $whole -= 1;
        }

        return sprintf(
            '%s.%02d',
            number_format($whole, 0, '', ','),
            $fraction
        );
    }
}
