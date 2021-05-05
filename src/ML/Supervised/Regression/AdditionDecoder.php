<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\Heuristic\Picture\Positional as PositionalHeuristicPicture;

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

        $this->heuristicPicture = PositionalHeuristicPicture::class;
        $this->labeller = AdditionLabeller::class;
    }
}
