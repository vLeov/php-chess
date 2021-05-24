<?php

namespace Chess\ML\Supervised\Classification;

use Chess\Board;
use Chess\HeuristicPicture;
use Chess\Combinatorics\RestrictedPermutationWithRepetition;
use Chess\Evaluation\AttackEvaluation;
use Chess\Evaluation\CenterEvaluation;
use Chess\Evaluation\ConnectivityEvaluation;
use Chess\Evaluation\KingSafetyEvaluation;
use Chess\Evaluation\MaterialEvaluation;
use Chess\Evaluation\PressureEvaluation;
use Chess\Evaluation\SpaceEvaluation;
use Chess\Evaluation\SquareEvaluation;
use Chess\Evaluation\TacticsEvaluation;
use Chess\ML\Supervised\AbstractDecoder;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

/**
 * LinearCombinationDecoder
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class LinearCombinationDecoder extends AbstractDecoder
{
    public function decode(string $color, int $prediction): string
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
                                Symbol::CASTLING_SHORT => $this->evaluate($clone, $color, $prediction, $permutations)
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_LONG))) {
                            $this->result[] = [
                                Symbol::CASTLING_LONG => $this->evaluate($clone, $color, $prediction, $permutations)
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.$square))) {
                            $this->result[] = [
                                Symbol::KING.$square => $this->evaluate($clone, $color, $prediction, $permutations)
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.'x'.$square))) {
                            $this->result[] = [
                                Symbol::KING.'x'.$square => $this->evaluate($clone, $color, $prediction, $permutations)
                            ];
                        }
                        break;
                    case Symbol::PAWN:
                        if ($clone->play(Convert::toStdObj($color, $square))) {
                            $this->result[] = [
                                $square => $this->evaluate($clone, $color, $prediction, $permutations)
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, $piece->getFile()."x$square"))) {
                            $this->result[] = [
                                $piece->getFile()."x$square" => $this->evaluate($clone, $color, $prediction, $permutations)
                            ];
                        }
                        break;
                    default:
                        if ($clone->play(Convert::toStdObj($color, $piece->getIdentity().$square))) {
                            $this->result[] = [
                                $piece->getIdentity().$square => $this->evaluate($clone, $color, $prediction, $permutations)
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, "{$piece->getIdentity()}x$square"))) {
                            $this->result[] = [
                                "{$piece->getIdentity()}x$square" => $this->evaluate($clone, $color, $prediction, $permutations)
                            ];
                        }
                        break;
                }
            }
        }

        $this->result = array_map("unserialize", array_unique(array_map("serialize", $this->result)));

        usort($this->result, function ($a, $b) {
            return current($b) <=> current($a);
        });

        return key($this->result[0]);
    }

    protected function evaluate(Board $clone, string $color, int $prediction, $permutations)
    {
        $permutation = $permutations[$prediction];

        $end = (new HeuristicPicture($clone->getMovetext()))
            ->setDimensions([
                MaterialEvaluation::class => $permutation[0],
                CenterEvaluation::class => $permutation[1],
                ConnectivityEvaluation::class => $permutation[2],
                SpaceEvaluation::class => $permutation[3],
                PressureEvaluation::class => $permutation[4],
                KingSafetyEvaluation::class => $permutation[5],
                TacticsEvaluation::class => $permutation[6],
                AttackEvaluation::class => $permutation[7],
            ])
            ->take()
            ->end();

        $evald = 0;
        foreach ($permutation as $key => $weight) {
            $evald += $weight * $end[$color][$key];
        }

        return $evald;
    }
}
