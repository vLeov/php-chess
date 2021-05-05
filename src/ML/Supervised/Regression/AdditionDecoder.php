<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\Heuristic\Picture\Standard as StandardHeuristicPicture;

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

        $this->heuristicPicture = StandardHeuristicPicture::class;
        $this->labeller = AdditionLabeller::class;
    }
}
