<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\Heuristic\Picture\Positional as PositionalHeuristicPicture;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

/**
 * LinearCombination decoder.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class LinearCombinationDecoder extends AbstractDecoder
{
    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->heuristicPicture = PositionalHeuristicPicture::class;
        $this->labeller = LinearCombinationLabeller::class;
    }

    public function decode(string $color, float $float): string
    {
        foreach ($this->board->getPiecesByColor($color) as $piece) {
            foreach ($piece->getLegalMoves() as $square) {
                $clone = unserialize(serialize($this->board));
                switch ($piece->getIdentity()) {
                    case Symbol::KING:
                        if ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_SHORT))) {
                            $heuristicPicture = new $this->heuristicPicture($clone->getMovetext());
                            $sample = $heuristicPicture->sample();
                            $this->result[] = [
                                Symbol::CASTLING_SHORT => (new $this->labeller($heuristicPicture, $sample))->label()[$color],
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::CASTLING_LONG))) {
                            $heuristicPicture = new $this->heuristicPicture($clone->getMovetext());
                            $sample = $heuristicPicture->sample();
                            $this->result[] = [
                                Symbol::CASTLING_LONG => (new $this->labeller($heuristicPicture, $sample))->label()[$color],
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.$square))) {
                            $heuristicPicture = new $this->heuristicPicture($clone->getMovetext());
                            $sample = $heuristicPicture->sample();
                            $this->result[] = [
                                Symbol::KING.$square => (new $this->labeller($heuristicPicture, $sample))->label()[$color],
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, Symbol::KING.'x'.$square))) {
                            $heuristicPicture = new $this->heuristicPicture($clone->getMovetext());
                            $sample = $heuristicPicture->sample();
                            $this->result[] = [
                                Symbol::KING.'x'.$square => (new $this->labeller($heuristicPicture, $sample))->label()[$color],
                            ];
                        }
                        break;
                    case Symbol::PAWN:
                        if ($clone->play(Convert::toStdObj($color, $square))) {
                            $heuristicPicture = new $this->heuristicPicture($clone->getMovetext());
                            $sample = $heuristicPicture->sample();
                            $this->result[] = [
                                $square => (new $this->labeller($heuristicPicture, $sample))->label()[$color],
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, $piece->getFile()."x$square"))) {
                            $heuristicPicture = new $this->heuristicPicture($clone->getMovetext());
                            $sample = $heuristicPicture->sample();
                            $this->result[] = [
                                $piece->getFile()."x$square" => (new $this->labeller($heuristicPicture, $sample))->label()[$color],
                            ];
                        }
                        break;
                    default:
                        if ($clone->play(Convert::toStdObj($color, $piece->getIdentity().$square))) {
                            $heuristicPicture = new $this->heuristicPicture($clone->getMovetext());
                            $sample = $heuristicPicture->sample();
                            $this->result[] = [
                                $piece->getIdentity().$square => (new $this->labeller($heuristicPicture, $sample))->label()[$color],
                            ];
                        } elseif ($clone->play(Convert::toStdObj($color, "{$piece->getIdentity()}x$square"))) {
                            $heuristicPicture = new $this->heuristicPicture($clone->getMovetext());
                            $sample = $heuristicPicture->sample();
                            $this->result[] = [
                                "{$piece->getIdentity()}x$square" => (new $this->labeller($heuristicPicture, $sample))->label()[$color],
                            ];
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
}
