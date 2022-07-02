<?php

namespace Chess\Tests\Unit\Eval\Material;

use Chess\Board;
use Chess\Player;
use Chess\Eval\ConnectivityEval;
use Chess\Tests\AbstractUnitTestCase;

class ConnectivityEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $connEval = (new ConnectivityEval(new Board()))->eval();

        $expected = [
            'w' => 20,
            'b' => 20,
        ];

        $this->assertSame($expected, $connEval);
    }

    /**
     * @test
     */
    public function ruy_lopez_lucena_defense()
    {
        $C60 = file_get_contents(self::DATA_FOLDER.'/sample/C60.pgn');

        $board = (new Player($C60))->play()->getBoard();

        $expected = [
            'w' => 19,
            'b' => 23,
        ];

        $connEval = (new ConnectivityEval($board))->eval();

        $this->assertSame($expected, $connEval);
    }
}
