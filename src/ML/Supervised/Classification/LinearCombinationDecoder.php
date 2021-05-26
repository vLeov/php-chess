<?php

namespace Chess\ML\Supervised\Classification;

use Chess\Board;
use Chess\HeuristicPicture;
use Chess\ML\Supervised\AbstractDecoder;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Rubix\ML\Datasets\Unlabeled;

/**
 * LinearCombinationDecoder
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class LinearCombinationDecoder extends AbstractDecoder
{
    public function decode(): string
    {
        $color = $this->board->getTurn();
        foreach ($this->board->getPiecesByColor($color) as $piece) {
            foreach ($piece->getLegalMoves() as $square) {
                $clone = unserialize(serialize($this->board));
                switch ($piece->getIdentity()) {
                    case Symbol::KING:
                        if ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_SHORT))) {
                            $this->result[] = [ Symbol::CASTLING_SHORT => $this->evaluate($clone) ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_LONG))) {
                            $this->result[] = [ Symbol::CASTLING_LONG => $this->evaluate($clone) ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.$square))) {
                            $this->result[] = [ Symbol::KING.$square => $this->evaluate($clone) ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.'x'.$square))) {
                            $this->result[] = [ Symbol::KING.'x'.$square => $this->evaluate($clone) ];
                        }
                        break;
                    case Symbol::PAWN:
                        if ($clone->play(Convert::toStdObj($color, $square))) {
                            $this->result[] = [ $square => $this->evaluate($clone) ];
                        } elseif ($clone->play(Convert::toStdObj($color, $piece->getFile()."x$square"))) {
                            $this->result[] = [ $piece->getFile()."x$square" => $this->evaluate($clone) ];
                        }
                        break;
                    default:
                        if ($clone->play(Convert::toStdObj($color, $piece->getIdentity().$square))) {
                            $this->result[] = [ $piece->getIdentity().$square => $this->evaluate($clone) ];
                        } elseif ($clone->play(Convert::toStdObj($color, "{$piece->getIdentity()}x$square"))) {
                            $this->result[] = [ "{$piece->getIdentity()}x$square" => $this->evaluate($clone) ];
                        }
                        break;
                }
            }
        }

        $this->result = array_map("unserialize", array_unique(array_map("serialize", $this->result)));

        usort($this->result, function ($a, $b) use ($color) {
            $color === Symbol::WHITE
                ? $current = current($b)['eval'] <=> current($a)['eval']
                : $current = current($a)['eval'] <=> current($b)['eval'];
            return $current;
        });

        return key($this->result[0]);
    }

    protected function evaluate(Board $clone)
    {
        $balance = (new HeuristicPicture($clone->getMovetext()))
            ->take()
            ->getBalance();

        $end = end($balance);

        $dataset = new Unlabeled([$end]);
        $prediction = current($this->estimator->predict($dataset));
        $permutation = $this->permutations[$prediction];

        $sum = 0;
        foreach ($end as $i => $val) {
            $sum += $permutation[$i] * $val;
        }

        return [
            'balance' => $end,
            'prediction' => $prediction,
            'eval' => $sum,
        ];
    }
}
