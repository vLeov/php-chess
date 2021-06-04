<?php

namespace Chess;

use Chess\PGN\Convert;
use Chess\PGN\Symbol;

/**
 * FEN to PGN converter.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class FenPgn
{
    private $fromFen;

    private $toFen;

    public function __construct(string $fromFen, string $toFen)
    {
        $this->fromFen = $fromFen;

        $this->toFen = $toFen;
    }

    public function create()
    {
        $legal = [];
        $board = (new FenBoard($this->fromFen))->create();
        $color = $board->getTurn();
        foreach ($board->getPiecesByColor($color) as $piece) {
            foreach ($piece->getLegalMoves() as $square) {
                $clone = unserialize(serialize($board));
                switch ($piece->getIdentity()) {
                    case Symbol::KING:
                        if ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_SHORT))) {
                            $legal[] = [
                                Symbol::CASTLING_SHORT => (new FenString($clone))->create()
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_LONG))) {
                            $legal[] = [
                                Symbol::CASTLING_LONG => (new FenString($clone))->create()
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.$square))) {
                            $legal[] = [
                                Symbol::KING.$square => (new FenString($clone))->create()
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.'x'.$square))) {
                            $legal[] = [
                                Symbol::KING.'x'.$square => (new FenString($clone))->create()
                            ];
                        }
                        break;
                    case Symbol::PAWN:
                        if ($clone->play(Convert::toStdObj($color, $square))) {
                            $legal[] = [
                                $square => (new FenString($clone))->create()
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, $piece->getFile()."x$square"))) {
                            $legal[] = [
                                $piece->getFile()."x$square" => (new FenString($clone))->create()
                            ];
                        }
                        break;
                    default:
                        if ($clone->play(Convert::toStdObj($color, $piece->getIdentity().$square))) {
                            $legal[] = [
                                $piece->getIdentity().$square => (new FenString($clone))->create()
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, "{$piece->getIdentity()}x$square"))) {
                            $legal[] = [
                                "{$piece->getIdentity()}x$square" => (new FenString($clone))->create()
                            ];
                        }
                        break;
                }
            }
        }
        $pgn = $this->find($legal);

        return $pgn;
    }

    private function find(array $legal)
    {
        foreach ($legal as $key => $val) {
            if ($this->toFen === current($val)) {
                return key($val);
            }
        }

        return null;
    }
}
