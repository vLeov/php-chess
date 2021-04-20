<?php

namespace Chess\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\AbstractDecoder;
use Chess\ML\Supervised\Regression\Labeller\PrimesLabeller;
use Chess\ML\Supervised\Regression\Sampler\PrimesSampler;

/**
 * Primes decoder.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class PrimesDecoder extends AbstractDecoder
{
    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->sampler = PrimesSampler::class;
        $this->labeller = PrimesLabeller::class;
    }
}
