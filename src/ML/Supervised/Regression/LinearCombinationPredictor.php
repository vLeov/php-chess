<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\HeuristicPicture;
use Chess\ML\Supervised\AbstractLinearCombinationPredictor;
use Chess\ML\Supervised\Regression\LinearCombinationLabeller;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

/**
 * LinearCombinationPredictor
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class LinearCombinationPredictor extends AbstractLinearCombinationPredictor
{
    public function predict(float $prediction): string
    {
        $color = $this->board->getTurn();
        foreach ($this->board->getPiecesByColor($color) as $piece) {
            foreach ($piece->getLegalMoves() as $square) {
                $clone = unserialize(serialize($this->board));
                switch ($piece->getIdentity()) {
                    case Symbol::KING:
                        if ($clone->play(Convert::toStdObj($color, Symbol::KING.$square))) {
                            $this->result[] = [ Symbol::KING.$square => $this->distance($clone, $prediction) ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.'x'.$square))) {
                            $this->result[] = [ Symbol::KING.'x'.$square => $this->distance($clone, $prediction) ];
                        }
                        break;
                    case Symbol::PAWN:
                        if ($clone->play(Convert::toStdObj($color, $square))) {
                            $this->result[] = [ $square => $this->distance($clone, $prediction) ];
                        } elseif ($clone->play(Convert::toStdObj($color, $piece->getFile()."x$square"))) {
                            $this->result[] = [ $piece->getFile()."x$square" => $this->distance($clone, $prediction) ];
                        }
                        break;
                    default:
                        if ($clone->play(Convert::toStdObj($color, $piece->getIdentity().$square))) {
                            $this->result[] = [ $piece->getIdentity().$square => $this->distance($clone, $prediction) ];
                        } elseif ($clone->play(Convert::toStdObj($color, "{$piece->getIdentity()}x$square"))) {
                            $this->result[] = [ "{$piece->getIdentity()}x$square" => $this->distance($clone, $prediction) ];
                        }
                        break;
                }
            }
        }

        $clone = unserialize(serialize($this->board));

        if ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_SHORT))) {
            $this->result[] = [ Symbol::CASTLING_SHORT => $this->distance($clone, $prediction) ];
        } elseif ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_LONG))) {
            $this->result[] = [ Symbol::CASTLING_LONG => $this->distance($clone, $prediction) ];
        }

        $this->result = array_map("unserialize", array_unique(array_map("serialize", $this->result)));

        usort($this->result, function ($a, $b) {
            return current($a) <=> current($b);
        });

        return key($this->result[0]);
    }

    protected function distance(Board $clone, float $prediction)
    {
        $end = (new HeuristicPicture($clone->getMovetext()))
            ->takeBalanced()
            ->end();

        $balance = (new LinearCombinationLabeller($this->permutations))->balance($end);

        return abs($prediction - $balance[$color]);
    }
}
