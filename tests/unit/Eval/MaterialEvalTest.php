<?php

namespace Chess\Tests\Unit\Eval;

use Chess\Board;
use Chess\Eval\MaterialEval;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\RuyLopez\LucenaDefense as RuyLopezLucenaDefense;

class MaterialEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function starting_position()
    {
        $board = new Board();

        $expected = [
            'w' => 40.06,
            'b' => 40.06,
        ];

        $mtlEval = (new MaterialEval($board))->eval();

        $this->assertEquals($expected, $mtlEval);
    }

    /**
     * @test
     */
    public function ruy_lopez_lucena_defense()
    {
        $board = (new RuyLopezLucenaDefense(new Board()))->play();

        $expected = [
            'w' => 40.06,
            'b' => 40.06,
        ];

        $mtlEval = (new MaterialEval($board))->eval();

        $this->assertSame($expected, $mtlEval);
    }

    /**
     * @test
     */
    public function w_e4_b_Nf6()
    {
        $board = new Board();
        $board->play('w', 'e4');
        $board->play('b', 'Nf6');

        $expected = [
            'w' => 40.06,
            'b' => 40.06,
        ];

        $mtlEval = (new MaterialEval($board))->eval();

        $this->assertEquals($expected, $mtlEval);
    }
}
