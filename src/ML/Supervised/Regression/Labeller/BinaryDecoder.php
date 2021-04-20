<?php

namespace Chess\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\AbstractDecoder;
use Chess\ML\Supervised\Regression\Labeller\BinaryLabeller;
use Chess\ML\Supervised\Regression\Sampler\BinarySampler;

/**
 * Binary decoder.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class BinaryDecoder extends AbstractDecoder
{
    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->sampler = new BinarySampler($board);
        $this->labeller = new BinaryLabeller($this->sampler->sample());
    }
}
