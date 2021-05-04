<?php

namespace Chess\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\AbstractDecoder;
use Chess\ML\Supervised\Regression\Labeller\AdditionLabeller;
use Chess\ML\Supervised\Regression\Sampler;

/**
 * Addition decoder.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class AdditionDecoder extends AbstractDecoder
{
    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->sampler = Sampler::class;
        $this->labeller = AdditionLabeller::class;
    }
}
