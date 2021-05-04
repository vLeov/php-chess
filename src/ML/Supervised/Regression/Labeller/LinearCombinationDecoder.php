<?php

namespace Chess\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\AbstractDecoder;
use Chess\ML\Supervised\Regression\Labeller\LinearCombinationLabeller;
use Chess\ML\Supervised\Regression\Sampler;

/**
 * LinearCombination decoder.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class LinearCombinationDecoder extends AbstractDecoder
{
    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->sampler = Sampler::class;
        $this->labeller = LinearCombinationLabeller::class;
    }
}
