<?php

namespace Chess;

use Chess\Board;
use Chess\Evaluation\AttackEvaluation;
use Chess\Evaluation\BackwardPawnEvaluation;
use Chess\Evaluation\CenterEvaluation;
use Chess\Evaluation\ConnectivityEvaluation;
use Chess\Evaluation\IsolatedPawnEvaluation;
use Chess\Evaluation\KingSafetyEvaluation;
use Chess\Evaluation\MaterialEvaluation;
use Chess\Evaluation\PressureEvaluation;
use Chess\Evaluation\SpaceEvaluation;
use Chess\Evaluation\TacticsEvaluation;
use Chess\Evaluation\DoubledPawnEvaluation;
use Chess\Evaluation\PassedPawnEvaluation;
use Chess\Evaluation\InverseEvaluationInterface;
use Chess\Evaluation\AbsolutePinEvaluation;
use Chess\Evaluation\RelativePinEvaluation;
use Chess\Evaluation\AbsoluteForkEvaluation;
use Chess\Evaluation\RelativeForkEvaluation;
use Chess\Evaluation\SquareOutpostEvaluation;
use Chess\Evaluation\KnightOutpostEvaluation;
use Chess\Evaluation\BishopOutpostEvaluation;
use Chess\FEN\StringToBoard;
use Chess\PGN\Symbol;

class HeuristicPictureByFenString
{
    protected $board;

    protected $dimensions = [
        MaterialEvaluation::class => 28,
        CenterEvaluation::class => 4,
        ConnectivityEvaluation::class => 4,
        SpaceEvaluation::class => 4,
        PressureEvaluation::class => 4,
        KingSafetyEvaluation::class => 4,
        TacticsEvaluation::class => 4,
        AttackEvaluation::class => 4,
        DoubledPawnEvaluation::class => 4,
        PassedPawnEvaluation::class => 4,
        IsolatedPawnEvaluation::class => 4,
        BackwardPawnEvaluation::class => 4,
        AbsolutePinEvaluation::class => 4,
        RelativePinEvaluation::class => 4,
        AbsoluteForkEvaluation::class => 4,
        RelativeForkEvaluation::class => 4,
        SquareOutpostEvaluation::class => 4,
        KnightOutpostEvaluation::class => 4,
        BishopOutpostEvaluation::class => 4,
    ];

    /**
     * The heuristic picture of $this->board.
     *
     * @var array
     */
    protected $picture = [];

    /**
     * The balanced heuristic picture of $this->board.
     *
     * @var array
     */
    protected $balance = [];

    public function __construct(string $fen)
    {
        $this->board = (new StringToBoard($fen))->create();
    }

    public function getDimensions(): array
    {
        return $this->dimensions;
    }

    public function setDimensions(array $dimensions): HeuristicPictureByFenString
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    public function getPicture(): array
    {
        return $this->picture;
    }

    public function getBalance(): array
    {
        return $this->balance;
    }

    /**
     * Takes a normalized, balanced heuristic picture.
     *
     * @return \Chess\Heuristic\HeuristicPictureByFenString
     */
    public function take(): HeuristicPictureByFenString
    {
        $item = [];
        foreach ($this->dimensions as $dimension => $w) {
            $evald = (new $dimension($this->board))->evaluate();
            if (is_array($evald[Symbol::WHITE])) {
                if ($dimension instanceof InverseEvaluationInterface) {
                    $item[] = [
                        Symbol::WHITE => count($evald[Symbol::BLACK]),
                        Symbol::BLACK => count($evald[Symbol::WHITE]),
                    ];
                } else {
                    $item[] = [
                        Symbol::WHITE => count($evald[Symbol::WHITE]),
                        Symbol::BLACK => count($evald[Symbol::BLACK]),
                    ];
                }
            } else {
                if ($dimension instanceof InverseEvaluationInterface) {
                    $item[] = [
                        Symbol::WHITE => $evald[Symbol::BLACK],
                        Symbol::BLACK => $evald[Symbol::WHITE],
                    ];
                } else {
                    $item[] = $evald;
                }
            }
        }
        $this->picture[Symbol::WHITE] = array_column($item, Symbol::WHITE);
        $this->picture[Symbol::BLACK] = array_column($item, Symbol::BLACK);

        $this->normalize()->balance();

        return $this;
    }

    public function evaluate(): array
    {
        $result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $weights = array_values($this->getDimensions());

        $pic = $this->take()->getPicture();

        for ($i = 0; $i < count($this->getDimensions()); $i++) {
            $result[Symbol::WHITE] += $weights[$i] * $pic[Symbol::WHITE][$i];
            $result[Symbol::BLACK] += $weights[$i] * $pic[Symbol::BLACK][$i];
        }

        $result[Symbol::WHITE] = round($result[Symbol::WHITE], 2);
        $result[Symbol::BLACK] = round($result[Symbol::BLACK], 2);

        return $result;
    }

    protected function normalize(): HeuristicPictureByFenString
    {
        $normalization = [];

        $values = array_merge(
            $this->picture[Symbol::WHITE],
            $this->picture[Symbol::BLACK]
        );

        $min = min($values);
        $max = max($values);

        for ($i = 0; $i < count($this->dimensions); $i++) {
            if ($max - $min > 0) {
                $normalization[Symbol::WHITE][$i] = round(($this->picture[Symbol::WHITE][$i] - $min) / ($max - $min), 2);
                $normalization[Symbol::BLACK][$i] = round(($this->picture[Symbol::BLACK][$i] - $min) / ($max - $min), 2);
            } elseif ($max == $min) {
                $normalization[Symbol::WHITE][$i] = round(1 / count($values), 2);
                $normalization[Symbol::BLACK][$i] = round(1 / count($values), 2);
            }
        }

        $this->picture = $normalization;

        return $this;
    }

    protected function balance(): HeuristicPictureByFenString
    {
        foreach ($this->picture[Symbol::WHITE] as $key => $val) {
            $this->balance[$key] = $this->picture[Symbol::WHITE][$key] - $this->picture[Symbol::BLACK][$key];
        }

        return $this;
    }
}
