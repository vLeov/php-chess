<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\Evaluation\SqEvaluation;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;

/**
 * Connectivity.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class ConnectivityEvaluation extends AbstractEvaluation
{
    const NAME = 'connectivity';

    private array $sqEval;

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $sqEval = new SqEvaluation($board);

        $this->sqEval = [
            SqEvaluation::TYPE_FREE => $sqEval->eval(SqEvaluation::TYPE_FREE),
            SqEvaluation::TYPE_USED => $sqEval->eval(SqEvaluation::TYPE_USED),
        ];

        $this->result = [
            Color::W => 0,
            Color::B => 0,
        ];
    }

    public function eval(): array
    {
        $this->color(Color::W);
        $this->color(Color::B);

        return $this->result;
    }

    private function color(string $color): void
    {
        foreach ($this->board->getPiecesByColor($color) as $piece) {
            switch ($piece->getId()) {
                case Piece::K:
                    $this->result[$color] += count(
                        array_intersect(array_values((array)$piece->getMobility()),
                        $this->sqEval[SqEvaluation::TYPE_USED][$color])
                    );
                    break;
                case Piece::N:
                    $this->result[$color] += count(
                        array_intersect($piece->getMobility(),
                        $this->sqEval[SqEvaluation::TYPE_USED][$color])
                    );
                    break;
                case Piece::P:
                    $this->result[$color] += count(
                        array_intersect($piece->getCaptureSqs(),
                        $this->sqEval[SqEvaluation::TYPE_USED][$color])
                    );
                    break;
                default:
                    foreach ((array)$piece->getMobility() as $key => $val) {
                        foreach ($val as $sq) {
                            if (in_array($sq, $this->sqEval[SqEvaluation::TYPE_USED][$color])) {
                                $this->result[$color] += 1;
                                break;
                            } elseif (in_array($sq, $this->sqEval[SqEvaluation::TYPE_USED][$piece->oppColor()])) {
                                break;
                            }
                        }
                    }
                    break;
            }
        }
    }
}
