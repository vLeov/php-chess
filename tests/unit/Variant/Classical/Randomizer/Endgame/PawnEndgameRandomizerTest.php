<?php

namespace Chess\Tests\Unit\Variant\Classical\Randomizer\Endgame;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Randomizer\Endgame\PawnEndgameRandomizer;

class PawnEndgameRandomizerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function w_get_board()
    {
        $board = (new PawnEndgameRandomizer($turn = Color::W))->getBoard();

        $this->assertNotEmpty($board->toFen());
    }

    /**
     * @test
     */
    public function b_get_board()
    {
        $board = (new PawnEndgameRandomizer($turn = Color::B))->getBoard();

        $this->assertNotEmpty($board->toFen());
    }
}
