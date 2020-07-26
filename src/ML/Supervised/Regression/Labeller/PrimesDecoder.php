<?php

namespace PGNChess\ML\Supervised\Regression\Labeller;

use PGNChess\Board;
use PGNChess\ML\Supervised\Regression\Labeller\Primes as PrimesLabeller;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;

/**
 * Primes decodeer.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class PrimesDecoder
{
    private $board;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->result = [];
    }

    /**
     * Decodes an MLP label being expressed as a linear combination of primes into a chess move.
     *
     * @return array
     */
    public function decode(string $color, float $float): string
    {
        foreach ($this->board->getPiecesByColor($color) as $piece) {
            foreach ($piece->getLegalMoves() as $square) {
                $clone = unserialize(serialize($this->board));
                switch ($piece->getIdentity()) {
                    // TODO
                    // King with castling
                    case Symbol::PAWN:
                        if ($clone->play(Convert::toStdObj($color, $square))) {
                            $this->result[] = [ $square => (new PrimesLabeller($clone))->calc()[$color] ];
                        } elseif ($clone->play(Convert::toStdObj($color, $piece->getFile()."x$square"))) {
                            $this->result[] = [ $piece->getFile()."x$square" => (new PrimesLabeller($clone))->calc()[$color] ];
                        }
                        break;
                    default:
                        if ($clone->play(Convert::toStdObj($color, $piece->getIdentity().$square))) {
                            $this->result[] = [ $piece->getIdentity().$square => (new PrimesLabeller($clone))->calc()[$color] ];
                        } elseif ($clone->play(Convert::toStdObj($color, "{$piece->getIdentity()}x$square"))) {
                            $this->result[] = [ "{$piece->getIdentity()}x$square" => (new PrimesLabeller($clone))->calc()[$color] ];
                        }
                        break;
                }
            }
        }

        return $this->pgn($this->closest(571));
    }

    private function closest(float $search)
    {
        $closest = null;
        foreach ($this->result as $key => $val) {
            if ($closest === null || abs($search - $closest) > abs(current($val) - $search)) {
                $closest = current($val);
            }
        }

        return $closest;
    }

    private function pgn(float $search)
    {
        foreach ($this->result as $key => $val) {
            if ($search === current($val)) {
                return key($val);
            }
        }
    }
}
