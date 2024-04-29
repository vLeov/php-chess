<?php

namespace Chess\Tests\Unit\Computer;

use Chess\Computer\GrandmasterComputer;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Board as ClassicalBoard;

class GrandmasterComputerTest extends AbstractUnitTestCase
{
    const FILEPATH = __DIR__.'/../../data/json/players.json';

    /**
     * @test
     */
    public function w_move()
    {
        $board = new ClassicalBoard();

        $move = (new GrandmasterComputer(self::FILEPATH))->move($board);

        $this->assertNotEmpty($move);
    }

    /**
     * @test
     */
    public function b_move()
    {
        $board = new ClassicalBoard();

        $board->play('w', 'e4');

        $move = (new GrandmasterComputer(self::FILEPATH))->move($board);

        $this->assertNotEmpty($move);
    }
}
