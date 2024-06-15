<?php

namespace Chess\Eval;

use Chess\Variant\AbstractBoard;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class DiagonalOppositionEval extends AbstractEval implements ExplainEvalInterface
{
    use ExplainEvalTrait;

    const NAME = 'Diagonal opposition';

    public function __construct(AbstractBoard $board)
    {
        $this->board = $board;

        $this->range = [1];

        $this->subject = [
            'The white king',
            'The black king',
        ];

        $this->observation = [
            "has the diagonal opposition preventing the advance of the other king",
        ];

        $wKingMobility = $this->board->piece(Color::W, Piece::K)->mobility;
        $bKingMobility = $this->board->piece(Color::B, Piece::K)->mobility;

        $wKingMobilityArr = array_values($wKingMobility);
        $bKingMobilityArr = array_values($bKingMobility);

        $intersect = array_intersect($wKingMobilityArr, $bKingMobilityArr);

        if (count($intersect) === 1) {
            $this->result = [
                Color::W => (int) ($this->board->turn !== Color::W),
                Color::B => (int) ($this->board->turn !== Color::B),
            ];
        }

        $this->explain($this->result);
    }
}
