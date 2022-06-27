<?php

namespace Chess\Eval;

use Chess\Board;
use Chess\Piece\P;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;

/**
 * SqOutpostEval
 *
 * @link https://en.wikipedia.org/wiki/Outpost_(chess)
 */
class SqOutpostEval extends AbstractEval
{
    const NAME = 'Square outpost';

    private array $ranks = [3, 4, 5, 6];

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Color::W => [],
            Color::B => [],
        ];
    }

    public function eval(): array
    {
        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() === Piece::P) {
                $captureSquares = $piece->getCaptureSqs();
                if ($piece->getColor() === Color::W) {
                    $lFile = chr(ord($piece->getFile()) - 2);
                    $rFile = chr(ord($piece->getFile()) + 2);
                } else {
                    $lFile = chr(ord($piece->getFile()) + 2);
                    $rFile = chr(ord($piece->getFile()) - 2);
                    rsort($captureSquares);
                }
                if (in_array($piece->getSq()[1], $this->ranks)) {
                    if (!$this->opposition($piece, $piece->getFile())) {
                        if ($lFile >= 'a' && $lFile <= 'h' &&
                            !$this->opposition($piece, $lFile)
                        ) {
                            $this->result[$piece->getColor()][] = $captureSquares[0];
                        }
                        if ($rFile >= 'a' && $rFile <= 'h' &&
                            !$this->opposition($piece, $rFile)
                        ) {
                            $this->result[$piece->getColor()][] = $captureSquares[0];
                            empty($captureSquares[1])
                                ?: $this->result[$piece->getColor()][] = $captureSquares[1];
                        }
                    }
                }
            }
        }
        $this->result[Color::W] = array_unique($this->result[Color::W]);
        $this->result[Color::B] = array_unique($this->result[Color::B]);
        sort($this->result[Color::W]);
        sort($this->result[Color::B]);

        return $this->result;
    }

    protected function opposition(P $pawn, string $file): bool
    {
        for ($i = 2; $i < 8; $i++) {
            if ($piece = $this->board->getPieceBySq($file.$i)) {
                if ($piece->getId() === Piece::P) {
                    if ($pawn->getColor() === Color::W) {
                        if ($pawn->getSq()[1] + 2 <= $piece->getSq()[1]) {
                            return true;
                        }
                    } else {
                        if ($pawn->getSq()[1] - 2 >= $piece->getSq()[1]) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}
