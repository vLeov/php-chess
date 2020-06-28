<?php

namespace PGNChess\Tests\Unit\Evaluation\Material;

use PGNChess\Board;
use PGNChess\Evaluation\Material as MaterialEvaluation;
use PGNChess\Evaluation\Value\System;
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
            Symbol::WHITE => 40.06,
            Symbol::BLACK => 40.06,
        ];

        $mtlEvald = (new MaterialEvaluation($board))->evaluate(System::SYSTEM_BERLINER);

        $this->assertEquals($expected, $mtlEvald);
    }
}
