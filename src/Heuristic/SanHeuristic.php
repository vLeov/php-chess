<?php

namespace Chess\Heuristic;

use Chess\EvalFactory;
use Chess\Play\SanPlay;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\Move;
use Chess\Variant\Classical\PGN\AN\Color;

/**
 * SanHeuristic
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class SanHeuristic extends SanPlay
{
    /**
     * The name of the evaluation feature.
     *
     * @var string
     */
    protected string $name;

    /**
     * The result.
     *
     * @var array
     */
    protected array $result;

    /**
     * The balance.
     *
     * @var array
     */
    protected array $balance = [];

    /**
     * Constructor.
     *
     * @param string $name
     * @param string $movetext
     * @param \Chess\Variant\Classical\Board|null $board
     */
    public function __construct(string $name, string $movetext = '', Board $board = null)
    {
        parent::__construct($movetext, $board);

        $this->name = $name;

        $this->calc()->balance();
    }

    /**
     * Returns the balance.
     *
     * @return array
     */
    public function getBalance(): array
    {
        return $this->balance;
    }

    /**
     * Calculates the result.
     *
     * @return \Chess\SanHeuristic
     */
    protected function calc(): SanHeuristic
    {
        foreach ($this->sanMovetext->getMoves() as $key => $val) {
            if ($val !== Move::ELLIPSIS) {
                if ($this->board->play($this->board->getTurn(), $val)) {
                    $eval = EvalFactory::create($this->name, $this->board);
                    $result = $eval->getResult();
                    if (is_array($result[Color::W])) {
                        if ($eval instanceof InverseEvalInterface) {
                            $this->result[] = [
                                Color::W => count($result[Color::B]),
                                Color::B => count($result[Color::W]),
                            ];
                        } else {
                            $this->result[] = [
                                Color::W => count($result[Color::W]),
                                Color::B => count($result[Color::B]),
                            ];
                        }
                    } else {
                        if ($eval instanceof InverseEvalInterface) {
                            $this->result[] = [
                                Color::W => $result[Color::B],
                                Color::B => $result[Color::W],
                            ];
                        } else {
                            $this->result[] = $result;
                        }
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Calculates the balance.
     *
     * @return SanHeuristic
     */
    protected function balance(): SanHeuristic
    {
        foreach ($this->result as $key => $val) {
            $this->balance[$key] =
                round($val[Color::W] - $val[Color::B], 2);
        }

        return $this;
    }
}
