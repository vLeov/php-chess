<?php

namespace PGNChess\Tests\Unit\Evaluation\Material;

use PGNChess\Board;
use PGNChess\Evaluation\Material as MaterialEvaluation;
use PGNChess\Opening\RuyLopez\LucenaDefense as RuyLopezLucenaDefense;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class OpeningTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function ruy_lopez_lucena_defense()
    {
        $board = (new RuyLopezLucenaDefense(new Board))->play();

        $expected = [
            Symbol::WHITE => 32.06,
            Symbol::BLACK => 32.06,
        ];

        $value = (new MaterialEvaluation($board))->evaluate(MaterialEvaluation::SYSTEM_BERLINER);

        $this->assertEquals($expected, $value);
    }
}
