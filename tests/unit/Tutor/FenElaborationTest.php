<?php

namespace Chess\Tests\Unit\Tutor;

use Chess\FenToBoardFactory;
use Chess\Play\SanPlay;
use Chess\Tutor\FenElaboration;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca\Board as CapablancaBoard;

class FenElaborationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function A08()
    {
        $expected = [];

        $A08 = file_get_contents(self::DATA_FOLDER.'/sample/A08.pgn');
        $board = (new SanPlay($A08))->validate()->getBoard();

        $paragraph = (new FenElaboration($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function endgame()
    {
        $expected = [
            "The knight on e6 is pinned shielding the king so it cannot move out of the line of attack because the king would be put in check.",
        ];

        $board = FenToBoardFactory::create('8/5k2/4n3/8/8/1BK5/1B6/8 w - - 0 1');

        $paragraph = (new FenElaboration($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function evaluated_endgame_plural()
    {
        $expected = [
            "The knight on e6 is pinned shielding the king so it cannot move out of the line of attack because the king would be put in check.",
        ];

        $board = FenToBoardFactory::create('8/5k2/4n3/8/8/1BK5/1B6/8 w - - 0 1');

        $paragraph = (new FenElaboration($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function evaluated_endgame_singular()
    {
        $expected = [];

        $board = FenToBoardFactory::create('rnb1kbnr/ppppqppp/8/4p3/4PP2/6P1/PPPP3P/RNBQKBNR w KQkq -');

        $paragraph = (new FenElaboration($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function evaluated_capablanca_f4()
    {
        $expected = [];

        $board = FenToBoardFactory::create(
            'rnabqkbcnr/pppppppppp/10/10/5P4/10/PPPPP1PPPP/RNABQKBCNR b KQkq f3',
            new CapablancaBoard()
        );

        $paragraph = (new FenElaboration($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function advanced_pawn()
    {
        $expected = [
            "h2 is a passed pawn.",
            "h2 is an advanced pawn.",
            "h2 is threatening to promote.",
            "h2 is an isolated pawn.",
        ];

        $board = FenToBoardFactory::create('8/8/8/8/8/8/7p/K6k b - - 0 1');

        $paragraph = (new FenElaboration($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function far_advanced_pawn()
    {
        $expected = [
            "h2 is a passed pawn.",
            "h2 is an advanced pawn.",
            "h2 is threatening to promote.",
            "h2 is an isolated pawn.",
        ];

        $board = FenToBoardFactory::create('8/8/8/8/8/8/7p/K6k b - - 0 1');

        $paragraph = (new FenElaboration($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function backward_pawn()
    {
        $expected = [
            "b4, c4, a3, d3, h7, g6 and f5 are passed pawns.",
            "a3 and d3 are backward pawns.",
            "a5, c5, b5, d5, b4, c4, g6, f5, h5 and g4 are outpost squares.",
        ];

        $board = FenToBoardFactory::create('k7/7p/6p1/5p2/1PP5/P2P4/8/7K w - - 0 1');

        $paragraph = (new FenElaboration($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function isolated_pawn()
    {
        $expected = [
            "a4 and c4 are passed pawns.",
            "a4, c4, e4, g4 and f7 are isolated pawns.",
            "b5, d5, f5, h5, e6 and g6 are outpost squares.",
        ];

        $board = FenToBoardFactory::create('k7/5p2/8/8/P1P1P1P1/8/8/K7 w - - 0 1');

        $paragraph = (new FenElaboration($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }
}
