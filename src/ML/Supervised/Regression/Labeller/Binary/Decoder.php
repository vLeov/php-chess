<?php

namespace Chess\ML\Supervised\Regression\Labeller\Binary;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\AbstractDecoder;
use Chess\ML\Supervised\Regression\Labeller\Binary\Labeller as BinaryLabeller;
use Chess\ML\Supervised\Regression\Sampler\Binary\Sampler as BinarySampler;

/**
 * Binary decoder.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Decoder extends AbstractDecoder
{
    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->sampler = new BinarySampler($board);
        $this->labeller = new BinaryLabeller($this->sampler->sample());
    }
}
