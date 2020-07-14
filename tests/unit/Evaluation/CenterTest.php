<?php

namespace PGNChess\Tests\Unit\Evaluation;

use PGNChess\Board;
use PGNChess\Evaluation\Center as CenterEvaluation;
use PGNChess\Evaluation\Value\System;
use PGNChess\Opening\RuyLopez\LucenaDefense as RuyLopezLucenaDefense;
use PGNChess\Opening\Sicilian\Closed as ClosedSicilian;
use PGNChess\Opening\Sicilian\Open as OpenSicilian;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class CenterTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function ruy_lopez_lucena_defense()
    {
        $board = (new RuyLopezLucenaDefense(new Board))->play();

        $expected = [
            Symbol::WHITE => 1,
            Symbol::BLACK => 1,
        ];

        $ctrEvald = (new CenterEvaluation($board))->evaluate(System::SYSTEM_BERLINER);

        $this->assertEquals($expected, $ctrEvald);
    }

    /**
     * @test
     */
    public function sicilian_open()
    {
        $board = (new OpenSicilian(new Board))->play();

        $expected = [
            Symbol::WHITE => 4.2,
            Symbol::BLACK => 0,
        ];

        $ctrEvald = (new CenterEvaluation($board))->evaluate(System::SYSTEM_BERLINER);

        $this->assertEquals($expected, $ctrEvald);
    }

    /**
     * @test
     */
    public function sicilian_closed()
    {
        $board = (new ClosedSicilian(new Board))->play();

        $expected = [
            Symbol::WHITE => 1,
            Symbol::BLACK => 0,
        ];

        $ctrEvald = (new CenterEvaluation($board))->evaluate(System::SYSTEM_BERLINER);

        $this->assertEquals($expected, $ctrEvald);
    }
}
