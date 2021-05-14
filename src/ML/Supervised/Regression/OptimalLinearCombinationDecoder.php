<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\Combinatorics\RestrictedPermutationWithRepetition;
use Chess\Heuristic\HeuristicPicture;
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
                [3, 5, 8, 13, 21],
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

        usort($this->result, function ($a, $b) {
            return current($a) <=> current($b);
        });

        return key($this->result[0]);
    }

    protected function distance(Board $clone, string $color, float $prediction, $permutations)
    {
        $heuristicPicture = new HeuristicPicture($clone->getMovetext());
        $sample = $heuristicPicture->sample();

        $labels = [];
        foreach ($permutations as $weights) {
            $label[$color] = 0;
            foreach ($sample[$color] as $key => $val) {
                $label[$color] += $weights[$key] * $val;
            }
            $labels[] = $label;
        }

        $distances = [];
        foreach ($labels as $key => $label) {
            $distances[$key] = abs($label[$color] - $prediction);
        }

        asort($distances);

        $closest = 0;
        foreach ($distances as $distance) {
           if (abs($prediction - $closest) > abs($distance - $prediction)) {
              $closest = $distance;
           }
        }

        return $closest;
    }
}
