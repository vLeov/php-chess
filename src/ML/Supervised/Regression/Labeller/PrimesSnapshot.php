<?php

namespace PGNChess\ML\Supervised\Regression\Labeller;

use PGNChess\AbstractSnapshot;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\ML\Supervised\Regression\Labeller\Primes as PrimesLabeller;

/**
 * Primes snapshot.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class PrimesSnapshot extends AbstractSnapshot
{
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $this->snapshot[] = (new PrimesLabeller($this->board))->calc();
        }

        return $this->snapshot;
    }
}
