<?php

namespace Chess\Eval;

use Chess\Piece\AbstractPiece;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Piece;

/**
 * Attack evaluation.
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class AttackEval extends AbstractEval
{
    use ElaborateEvalTrait;
    
    const NAME = 'Attack';

    public function __construct(Board $board)
    {
        $this->board = $board;

        foreach ($this->board->getPieces() as $piece) {
            switch ($piece->getId()) {
                case Piece::K:
                    // TODO ...
                    break;
                case Piece::P:
                    foreach ($piece->getCaptureSqs() as $sq) {
                        if ($item = $this->board->getPieceBySq($sq)) {
                            if ($item->getColor() !== $piece->getColor()) {
                                $id = $item->getId();
                                if ($id !== Piece::K && self::$value[Piece::P] < self::$value[$id]) {
                                    $this->result[$piece->getColor()] += self::$value[$id] - self::$value[Piece::P];
                                    $this->elaborate($piece, $item);
                                }
                            }
                        }
                    }
                    break;
                default:
                    foreach ($piece->sqs() as $sq) {
                        if ($item = $this->board->getPieceBySq($sq)) {
                            if ($item->getColor() !== $piece->getColor()) {
                                $id = $item->getId();
                                if ($id !== Piece::K && self::$value[$piece->getId()] < self::$value[$id]) {
                                    $this->result[$piece->getColor()] += self::$value[$id] - self::$value[$piece->getId()];
                                    $this->elaborate($piece, $item);
                                }
                            }
                        }
                    }
                    break;
            }
        }
    }

    private function elaborate(AbstractPiece $attackingPiece, AbstractPiece $attackedPiece): void
    {
        $attacking = PiecePhrase::create($attackingPiece);
        $attacked = PiecePhrase::create($attackedPiece);

        $this->elaboration[] = ucfirst("{$attacking} is attacking {$attacked}.");
    }
}
