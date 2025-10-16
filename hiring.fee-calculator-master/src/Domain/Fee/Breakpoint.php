<?php

namespace Lendable\Interview\Domain\Fee;

final class Breakpoint
{
    private int $amount;
    private int $fee;

    public function __construct(int $amount, int $fee)
    {
        $this->amount = $amount;
        $this->fee = $fee;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function fee(): int
    {
        return $this->fee;
    }
}
