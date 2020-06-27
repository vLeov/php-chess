<?php

namespace PGNChess\Tests\Unit\Evaluation\Material;

use PGNChess\Board;
use PGNChess\Evaluation\Material as MaterialEvaluation;
use PGNChess\Evaluation\Value\System;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class SystemTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function berliner()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => 32.06,
            Symbol::BLACK => 32.06,
        ];

        $mtlEvald = (new MaterialEvaluation($board))->evaluate(System::SYSTEM_BERLINER);

        $this->assertEquals($expected, $mtlEvald);
    }

    /**
     * @test
     */
    public function bilguer()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => 35.7,
            Symbol::BLACK => 35.7,
        ];

        $mtlEvald = (new MaterialEvaluation($board))->evaluate(System::SYSTEM_BILGUER);

        $this->assertEquals($expected, $mtlEvald);
    }

    /**
     * @test
     */
    public function fisher()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => 31.5,
            Symbol::BLACK => 31.5,
        ];

        $mtlEvald = (new MaterialEvaluation($board))->evaluate(System::SYSTEM_FISHER);

        $this->assertEquals($expected, $mtlEvald);
    }

    /**
     * @test
     */
    public function kasparov()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => 30,
            Symbol::BLACK => 30,
        ];

        $mtlEvald = (new MaterialEvaluation($board))->evaluate(System::SYSTEM_KASPAROV);

        $this->assertEquals($expected, $mtlEvald);
    }

    /**
     * @test
     */
    public function kaufman()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => 32.75,
            Symbol::BLACK => 32.75,
        ];

        $mtlEvald = (new MaterialEvaluation($board))->evaluate(System::SYSTEM_KAUFMAN);

        $this->assertEquals($expected, $mtlEvald);
    }

    /**
     * @test
     */
    public function lasker()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => 35,
            Symbol::BLACK => 35,
        ];

        $mtlEvald = (new MaterialEvaluation($board))->evaluate(System::SYSTEM_LASKER);

        $this->assertEquals($expected, $mtlEvald);
    }

    /**
     * @test
     */
    public function philidor()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => 34,
            Symbol::BLACK => 34,
        ];

        $mtlEvald = (new MaterialEvaluation($board))->evaluate(System::SYSTEM_PHILIDOR);

        $this->assertEquals($expected, $mtlEvald);
    }

    /**
     * @test
     */
    public function pratt()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => 32,
            Symbol::BLACK => 32,
        ];

        $mtlEvald = (new MaterialEvaluation($board))->evaluate(System::SYSTEM_PRATT);

        $this->assertEquals($expected, $mtlEvald);
    }

    /**
     * @test
     */
    public function sarrat()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => 32.9,
            Symbol::BLACK => 32.9,
        ];

        $mtlEvald = (new MaterialEvaluation($board))->evaluate(System::SYSTEM_SARRAT);

        $this->assertEquals($expected, $mtlEvald);
    }
}
