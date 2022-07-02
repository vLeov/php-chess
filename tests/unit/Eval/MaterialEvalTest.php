<?php

namespace Chess\Tests\Unit\Eval;

use Chess\Board;
use Chess\Player;
use Chess\Eval\MaterialEval;
use Chess\Tests\AbstractUnitTestCase;

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
        $C60 = file_get_contents(self::DATA_FOLDER.'/sample/C60.pgn');

        $board = (new Player($C60))->play()->getBoard();

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
