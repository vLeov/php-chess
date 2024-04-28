<?php

namespace Chess\Eval;

use Chess\Piece\AbstractPiece;
use Chess\Tutor\PiecePhrase;
use Chess\Variant\Classical\Board;

class ThreatEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    const NAME = 'Threat';

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->range = [1, 5];

        $this->subject = [
            'White',
            'Black',
        ];

        $this->observation = [
            "has a small threat advantage",
            "has some threat advantage",
            "has a significant threat advantage",
            "has a total threat advantage",
        ];

        foreach ($this->board->getPieces() as $piece) {
            $countAttacking = count($piece->attackingPieces());
            $countDefending = count($piece->defendingPieces());
            $diff = $countAttacking - $countDefending;
            if ($diff > 0 && $countDefending > 0) {
                $valueDefending = $this->valueDefending($piece->defendingPieces());
                $valueAttacking = $this->valueAttacking($piece->attackingPieces());
                if (($valueDefending + self::$value[$piece->getId()]) >= $valueAttacking) {
                    $this->result[$piece->oppColor()] += $diff;
                    $this->elaborate($piece);
                }
            }
        }

        $this->explain($this->result);
    }

    private function valueDefending(array $pieces)
    {
        $sum = 0;
        foreach ($pieces as $piece) {
            $sum += self::$value[$piece->getId()];
        }

        return $sum;
    }

    private function valueAttacking(array $pieces)
    {
        $values = [];
        foreach ($pieces as $piece) {
            $values[] = self::$value[$piece->getId()];
        }
        sort($values);
        array_pop($values);

        return array_sum($values);
    }

    private function elaborate(AbstractPiece $piece): void
    {
        $phrase = PiecePhrase::create($piece);

        $this->elaboration[] = ucfirst("$phrase is being threatened and may be lost if not defended properly.");
    }
}
