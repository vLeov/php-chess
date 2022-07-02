<?php

namespace Chess\Tests\Unit\Eval;

use Chess\Board;
use Chess\Player;
use Chess\Eval\CenterEval;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class CenterEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function ruy_lopez_lucena_defense()
    {
        $C60 = file_get_contents(self::DATA_FOLDER.'/sample/C60.pgn');

        $board = (new Player($C60))->play()->getBoard();

        $expected = [
            'w' => 37.73,
            'b' => 34.73,
        ];

        $ctrEval = (new CenterEval($board))->eval();

        $this->assertSame($expected, $ctrEval);
    }

    /**
     * @test
     */
    public function sicilian_open()
    {
        $board = (new OpenSicilian(new Board()))->play();

        $expected = [
            'w' => 49.0,
            'b' => 31.4,
        ];

        $ctrEval = (new CenterEval($board))->eval();

        $this->assertSame($expected, $ctrEval);
    }

    /**
     * @test
     */
    public function sicilian_closed()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $expected = [
            'w' => 37.73,
            'b' => 34.73,
        ];

        $ctrEval = (new CenterEval($board))->eval();

        $this->assertSame($expected, $ctrEval);
    }
}
