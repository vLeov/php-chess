<?php

namespace Chess\ML\Supervised\Regression\Labeller\Primes;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\AbstractDecoder;
use Chess\ML\Supervised\Regression\Labeller\Primes\Labeller as PrimesLabeller;
use Chess\ML\Supervised\Regression\Sampler\Primes\Sampler as PrimesSampler;

/**
 * Primes decoder.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Decoder extends AbstractDecoder
{
    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->sampler = new PrimesSampler($board);
        $this->labeller = new PrimesLabeller($this->sampler->sample());
    }
}
