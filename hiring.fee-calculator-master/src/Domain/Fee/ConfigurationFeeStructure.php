<?php

namespace Lendable\Interview\Domain\Fee;

use InvalidArgumentException;
use Lendable\Interview\Domain\Loan\LoanTerm;

final class ConfigurationFeeStructure implements FeeStructure
{
    /** @var array<int, BreakpointSeries> */
    private array $seriesByTerm;

    /**
     * @param array<int, BreakpointSeries> $seriesByTerm
     */
    public function __construct(array $seriesByTerm)
    {
        $this->seriesByTerm = $seriesByTerm;
    }

    public static function withDefaults(): self
    {
        return new self([
            LoanTerm::TwelveMonths->value => BreakpointSeries::fromArray([
                1000 => 50,
                2000 => 90,
                3000 => 90,
                4000 => 115,
                5000 => 100,
                6000 => 120,
                7000 => 140,
                8000 => 160,
                9000 => 180,
                10000 => 200,
                11000 => 220,
                12000 => 240,
                13000 => 260,
                14000 => 280,
                15000 => 300,
                16000 => 320,
                17000 => 340,
                18000 => 360,
                19000 => 380,
                20000 => 400,
            ]),
            LoanTerm::TwentyFourMonths->value => BreakpointSeries::fromArray([
                1000 => 70,
                2000 => 100,
                3000 => 120,
                4000 => 160,
                5000 => 200,
                6000 => 240,
                7000 => 280,
                8000 => 320,
                9000 => 360,
                10000 => 400,
                11000 => 440,
                12000 => 480,
                13000 => 520,
                14000 => 560,
                15000 => 600,
                16000 => 640,
                17000 => 680,
                18000 => 720,
                19000 => 760,
                20000 => 800,
            ]),
        ]);
    }

    public function forTerm(LoanTerm $term): BreakpointSeries
    {
        $key = $term->value;

        if (!isset($this->seriesByTerm[$key])) {
            throw new InvalidArgumentException(sprintf('No fee structure configured for term %d.', $key));
        }

        return $this->seriesByTerm[$key];
    }
}
