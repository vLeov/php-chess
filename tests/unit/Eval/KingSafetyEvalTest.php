<?php

namespace Chess\Tests\Unit\Eval;

use Chess\Board;
use Chess\Player;
use Chess\Eval\KingSafetyEval;
use Chess\Tests\AbstractUnitTestCase;

class KingSafetyEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $kSafetyEval = (new KingSafetyEval(new Board()))->eval();

        $expected = [
            'w' => 1,
            'b' => 1,
        ];

        $this->assertSame($expected, $kSafetyEval);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $B56 = file_get_contents(self::DATA_FOLDER.'/sample/B56.pgn');

        $board = (new Player($B56))->play()->getBoard();

        $kSafetyEval = (new KingSafetyEval($board))->eval();

        $expected = [
            'w' => 1,
            'b' => 1,
        ];

        $this->assertSame($expected, $kSafetyEval);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $B25 = file_get_contents(self::DATA_FOLDER.'/sample/B25.pgn');

        $board = (new Player($B25))->play()->getBoard();

        $kSafetyEval = (new KingSafetyEval($board))->eval();

        $expected = [
            'w' => 1,
            'b' => 1,
        ];

        $this->assertSame($expected, $kSafetyEval);
    }
}
