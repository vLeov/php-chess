<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\Combinatorics\RestrictedPermutationWithRepetition;
use Chess\Heuristic\HeuristicPicture;
use Chess\ML\Supervised\AbstractDecoder;
use Chess\ML\Supervised\Regression\OptimalLinearCombinationLabeller;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

/**
 * OptimalLinearCombinationDecoder
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class OptimalLinearCombinationDecoder extends AbstractDecoder
{
    public function decode(string $color, float $prediction): string
    {
        $permutations = (new RestrictedPermutationWithRepetition())
            ->get(
                [ 8, 13, 21, 34],
                count((new HeuristicPicture(''))->getDimensions()),
                100
            );

        foreach ($this->board->getPiecesByColor($color) as $piece) {
            foreach ($piece->getLegalMoves() as $square) {
                $clone = unserialize(serialize($this->board));
                switch ($piece->getIdentity()) {
                    case Symbol::KING:
                        if ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_SHORT))) {
                            $this->result[] = [
                                Symbol::CASTLING_SHORT => $this->distance($clone, $color, $prediction, $permutations)
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_LONG))) {
                            $this->result[] = [
                                Symbol::CASTLING_LONG => $this->distance($clone, $color, $prediction, $permutations)
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.$square))) {
                            $this->result[] = [
                                Symbol::KING.$square => $this->distance($clone, $color, $prediction, $permutations)
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.'x'.$square))) {
                            $this->result[] = [
                                Symbol::KING.'x'.$square => $this->distance($clone, $color, $prediction, $permutations)
                            ];
                        }
                        break;
                    case Symbol::PAWN:
                        if ($clone->play(Convert::toStdObj($color, $square))) {
                            $this->result[] = [
                                $square => $this->distance($clone, $color, $prediction, $permutations)
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, $piece->getFile()."x$square"))) {
                            $this->result[] = [
                                $piece->getFile()."x$square" => $this->distance($clone, $color, $prediction, $permutations)
                            ];
                        }
                        break;
                    default:
                        if ($clone->play(Convert::toStdObj($color, $piece->getIdentity().$square))) {
                            $this->result[] = [
                                $piece->getIdentity().$square => $this->distance($clone, $color, $prediction, $permutations)
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, "{$piece->getIdentity()}x$square"))) {
                            $this->result[] = [
                                "{$piece->getIdentity()}x$square" => $this->distance($clone, $color, $prediction, $permutations)
                            ];
                        }
                        break;
                }
            }
        }

        $this->result = array_map("unserialize", array_unique(array_map("serialize", $this->result)));

        usort($this->result, function ($a, $b) {
            return current($a) <=> current($b);
        });

        return key($this->result[0]);
    }

    protected function distance(Board $clone, string $color, float $prediction, $permutations)
    {
        $end = (new HeuristicPicture($clone->getMovetext()))
            ->takeBalanced()
            ->end();

        $balance = (new OptimalLinearCombinationLabeller($permutations))->balance($end);

        return abs($prediction - $balance[$color]);
    }
}
