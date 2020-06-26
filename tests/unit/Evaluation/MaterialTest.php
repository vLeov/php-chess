<?php

namespace PGNChess\Tests\Unit\Evaluation;

use PGNChess\Board;
use PGNChess\Evaluation\Material as MaterialEvaluation;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class MaterialTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function berliner()
    {
        $board = new Board();

        $expected = [
            Symbol::WHITE => 32.059999999999995,
            Symbol::BLACK => 32.059999999999995,
        ];

        $value = (new MaterialEvaluation($board))->evaluate(MaterialEvaluation::SYSTEM_BERLINER);

        $this->assertEquals($expected, $value);
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

        $value = (new MaterialEvaluation($board))->evaluate(MaterialEvaluation::SYSTEM_BILGUER);

        $this->assertEquals($expected, $value);
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

        $value = (new MaterialEvaluation($board))->evaluate(MaterialEvaluation::SYSTEM_FISHER);

        $this->assertEquals($expected, $value);
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

        $value = (new MaterialEvaluation($board))->evaluate(MaterialEvaluation::SYSTEM_KASPAROV);

        $this->assertEquals($expected, $value);
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

        $value = (new MaterialEvaluation($board))->evaluate(MaterialEvaluation::SYSTEM_KAUFMAN);

        $this->assertEquals($expected, $value);
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

        $value = (new MaterialEvaluation($board))->evaluate(MaterialEvaluation::SYSTEM_LASKER);

        $this->assertEquals($expected, $value);
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

        $value = (new MaterialEvaluation($board))->evaluate(MaterialEvaluation::SYSTEM_PHILIDOR);

        $this->assertEquals($expected, $value);
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

        $value = (new MaterialEvaluation($board))->evaluate(MaterialEvaluation::SYSTEM_PRATT);

        $this->assertEquals($expected, $value);
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

        $value = (new MaterialEvaluation($board))->evaluate(MaterialEvaluation::SYSTEM_SARRAT);

        $this->assertEquals($expected, $value);
    }
}
