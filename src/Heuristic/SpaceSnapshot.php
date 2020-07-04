<?php

namespace PGNChess\Heuristic;

use PGNChess\AbstractHeuristicSnapshot;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Evaluation\Space as SpaceEvaluation;

/**
 * Space snapshot.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class SpaceSnapshot extends AbstractHeuristicSnapshot
{
    public function take(): array
    {
        $result = [];
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $spEvald = (new SpaceEvaluation($this->board))->evaluate();
            $result[] = [
                Symbol::WHITE => count($spEvald[Symbol::WHITE]),
                Symbol::BLACK => count($spEvald[Symbol::BLACK]),
            ];
        }

        return $result;
    }
}
