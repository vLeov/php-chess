<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

/**
 * AbstractDecoder
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
abstract class AbstractDecoder
{
    protected $board;

    protected $result = [];

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function decode(string $color, float $float): string
    {
        foreach ($this->board->getPiecesByColor($color) as $piece) {
            foreach ($piece->getLegalMoves() as $square) {
                $clone = unserialize(serialize($this->board));
                switch ($piece->getIdentity()) {
                    case Symbol::KING:
                        if ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_SHORT))) {
                            $this->result[] = [ Symbol::CASTLING_SHORT => $this->label($clone, $color) ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_LONG))) {
                            $this->result[] = [ Symbol::CASTLING_LONG => $this->label($clone, $color) ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.$square))) {
                            $this->result[] = [ Symbol::KING.$square => $this->label($clone, $color) ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.'x'.$square))) {
                            $this->result[] = [ Symbol::KING.'x'.$square => $this->label($clone, $color) ];
                        }
                        break;
                    case Symbol::PAWN:
                        if ($clone->play(Convert::toStdObj($color, $square))) {
                            $this->result[] = [ $square => $this->label($clone, $color) ];
                        } elseif ($clone->play(Convert::toStdObj($color, $piece->getFile()."x$square"))) {
                            $this->result[] = [ $piece->getFile()."x$square" => $this->label($clone, $color) ];
                        }
                        break;
                    default:
                        if ($clone->play(Convert::toStdObj($color, $piece->getIdentity().$square))) {
                            $this->result[] = [ $piece->getIdentity().$square => $this->label($clone, $color) ];
                        } elseif ($clone->play(Convert::toStdObj($color, "{$piece->getIdentity()}x$square"))) {
                            $this->result[] = [ "{$piece->getIdentity()}x$square" => $this->label($clone, $color) ];
                        }
                        break;
                }
            }
        }

        usort($this->result, function ($a, $b) {
            return current($b) <=> current($a);
        });

        return $this->pgn($this->closest($float));
    }

    protected function closest(float $search)
    {
        $closest = [];
        foreach ($this->result as $key => $val) {
            $closest[$key] = abs(current($val) - $search);
        }
        asort($closest);

        return current($this->result[array_key_first($closest)]);
    }

    protected function pgn(float $search)
    {
        foreach ($this->result as $key => $val) {
            if ($search === current($val)) {
                return key($val);
            }
        }
    }

    abstract protected function label(Board $clone, string $color);
}
