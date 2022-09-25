<?php

namespace Chess\Tests\Unit\Variant\Classical\Randomizer\Checkmate;

use Chess\FEN\BoardToStr;
use Chess\PGN\AN\Color;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Randomizer\Checkmate\TwoBishopsRandomizer;

class TwoBishopsRandomizerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function w_get_board()
    {
        $board = (new TwoBishopsRandomizer($turn = Color::W))->getBoard();

        $fen = (new BoardToStr($board))->create();

        $this->assertNotEmpty($fen);
    }

    /**
     * @test
     */
    public function b_get_board()
    {
        $board = (new TwoBishopsRandomizer($turn = Color::B))->getBoard();

        $fen = (new BoardToStr($board))->create();

        $this->assertNotEmpty($fen);
    }
}
