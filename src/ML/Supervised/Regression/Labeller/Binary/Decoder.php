<?php

namespace Chess\ML\Supervised\Regression\Labeller\Binary;

use Chess\Board;
use Chess\ML\Supervised\Regression\Labeller\Binary\Labeller as BinaryLabeller;
use Chess\ML\Supervised\Regression\Sampler\Binary\Sampler as BinarySampler;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;

/**
 * Binary decoder.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class Decoder
{
    private $board;

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->result = [];
    }

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
                            $sample = (new BinarySampler($clone))->sample();
                            $this->result[] = [ $square => (new BinaryLabeller($sample))->label()[$color] ];
                        } elseif ($clone->play(Convert::toStdObj($color, $piece->getFile()."x$square"))) {
                            $sample = (new BinarySampler($clone))->sample();
                            $this->result[] = [ $piece->getFile()."x$square" => (new BinaryLabeller($sample))->label()[$color] ];
                        }
                        break;
                    default:
                        if ($clone->play(Convert::toStdObj($color, $piece->getIdentity().$square))) {
                            $sample = (new BinarySampler($clone))->sample();
                            $this->result[] = [ $piece->getIdentity().$square => (new BinaryLabeller($sample))->label()[$color] ];
                        } elseif ($clone->play(Convert::toStdObj($color, "{$piece->getIdentity()}x$square"))) {
                            $sample = (new BinarySampler($clone))->sample();
                            $this->result[] = [ "{$piece->getIdentity()}x$square" => (new BinaryLabeller($sample))->label()[$color] ];
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

    private function closest(float $search)
    {
        $closest = [];
        foreach ($this->result as $key => $val) {
            $closest[$key] = abs(current($val) - $search);
        }
        asort($closest);

        return current($this->result[array_key_first($closest)]);
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
