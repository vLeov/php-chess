<?php

namespace PGNChess\Evaluation;

use PgnChess\Board;
use PGNChess\PGN\Symbol;

/**
 * Capture.
 *
 * TODO: This is more of a Fact or Event class rather than an Evaluation class.
 * Similarly as with PGNChess\Evaluation\Check a capture behaves as a kind of
 * digital signal when it comes to training the model, so it's not necessary to
 * normalize a Heuristic\CaptureSnapshot.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Capture extends AbstractEvaluation
{
    const NAME = 'capture';

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function evaluate($feature = null): array
    {
        $color = Symbol::oppColor($this->board->getTurn());
        $last = array_slice($this->board->getHistory(), -1)[0];
        $this->result[$color] = (int) ($last->move->isCapture && $last->move->color === $color);

        return $this->result;
    }
}
