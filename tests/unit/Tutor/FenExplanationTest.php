<?php

namespace Chess\Tests\Unit\Tutor;

use Chess\FenToBoardFactory;
use Chess\Play\SanPlay;
use Chess\Tutor\FenExplanation;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca\Board as CapablancaBoard;

class FenExplanationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function A08()
    {
        $expected = [
            "Black has a significant control of the center.",
            "The white pieces are so better connected.",
            "Black has a significant space advantage.",
        ];

        $A08 = file_get_contents(self::DATA_FOLDER.'/sample/A08.pgn');
        $board = (new SanPlay($A08))->validate()->getBoard();

        $paragraph = (new FenExplanation($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function evaluated_endgame()
    {
        $expected = [
            "White has a significant material advantage.",
            "White has a significant control of the center.",
            "The white pieces are somewhat better connected.",
            "The white player is pressuring a little bit more squares than its opponent.",
            "White has some absolute pin advantage.",
            "White has the bishop pair.",
            "Overall, 6 heuristic evaluation features are favoring White while 0 are favoring Black.",
        ];

        $board = FenToBoardFactory::create('8/5k2/4n3/8/8/1BK5/1B6/8 w - - 0 1');

        $paragraph = (new FenExplanation($board, $isEvaluated = true))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function advanced_pawn()
    {
        $expected = [
            "Black has a small material advantage.",
            "The black pieces are slightly better connected.",
            "White has a small space advantage.",
            "Black has a small passed pawn advantage.",
            "Black has a small advanced pawn advantage.",
            "Black has a small far advanced pawn advantage.",
            "White has a small isolated pawn advantage.",
        ];

        $board = FenToBoardFactory::create('8/8/8/8/8/8/7p/K6k b - - 0 1');

        $paragraph = (new FenExplanation($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function far_advanced_pawn()
    {
        $expected = [
            "Black has a small material advantage.",
            "The black pieces are slightly better connected.",
            "White has a small space advantage.",
            "Black has a small passed pawn advantage.",
            "Black has a small advanced pawn advantage.",
            "Black has a small far advanced pawn advantage.",
            "White has a small isolated pawn advantage.",
        ];

        $board = FenToBoardFactory::create('8/8/8/8/8/8/7p/K6k b - - 0 1');

        $paragraph = (new FenExplanation($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function backward_pawn()
    {
        $expected = [
            "White has a small material advantage.",
            "White is totally controlling the center.",
            "White has a small space advantage.",
            "White has a small passed pawn advantage.",
            "Black has some backward pawn advantage.",
            "White has some outpost advantage.",
        ];

        $board = FenToBoardFactory::create('k7/7p/6p1/5p2/1PP5/P2P4/8/7K w - - 0 1');

        $paragraph = (new FenExplanation($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function isolated_pawn()
    {
        $expected = [
            "White has a significant material advantage.",
            "White is totally controlling the center.",
            "White has a small space advantage.",
            "White has some passed pawn advantage.",
            "Black has a significant isolated pawn advantage.",
            "White has some outpost advantage.",
        ];

        $board = FenToBoardFactory::create('k7/5p2/8/8/P1P1P1P1/8/8/K7 w - - 0 1');

        $paragraph = (new FenExplanation($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function relative_pin()
    {
        $expected = [
            "White is totally controlling the center.",
            "The black pieces are significantly better connected.",
            "White has a small space advantage.",
            "White has some absolute pin advantage.",
            "Black has a significant relative pin advantage.",
        ];

        $board = FenToBoardFactory::create('r2qkbnr/ppp2ppp/2np4/1B2p3/3PP1b1/5N2/PPP2PPP/RNBQK2R w KQkq -');

        $paragraph = (new FenExplanation($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function attack()
    {
        $expected = [
            "White has a small material advantage.",
            "White is totally controlling the center.",
            "The black pieces are so better connected.",
            "White has a small space advantage.",
            "The white player is really pressuring more squares than its opponent.",
            "The white pieces are approaching the other side's king.",
            "Black has a decisive protection advantage.",
            "Black has some attack advantage.",
            "White has a bishop which is not too good because a few of its pawns are blocking it.",
        ];

        $board = FenToBoardFactory::create('r1bqkbnr/1ppp1ppp/p1n5/1B2N3/4P3/8/PPPP1PPP/RNBQK2R b KQkq -');

        $paragraph = (new FenExplanation($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function bad_bishop()
    {
        $expected = [
            "White is totally controlling the center.",
            "The white pieces are somewhat better connected.",
            "Black has a small space advantage.",
            "The white player is really pressuring more squares than its opponent.",
            "The black pieces are approaching the other side's king.",
            "White has some isolated pawn advantage.",
            "Black has a small backward pawn advantage.",
            "White has some outpost advantage.",
            "Black has a bad bishop because too many of its pawns are blocking it.",
            "The black king has the direct opposition preventing the advance of the other king.",
        ];

        $board = FenToBoardFactory::create('8/5b2/p2k4/1p1p1p1p/1P1K1P1P/2P1PB2/8/8 w - - 0 1');

        $paragraph = (new FenExplanation($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function square_outpost()
    {
        $expected = [
            "Black is totally controlling the center.",
            "Black has a small space advantage.",
            "Black has a small outpost advantage.",
        ];

        $board = FenToBoardFactory::create('5k2/7K/8/2p5/P7/8/8/8 w - -');

        $paragraph = (new FenExplanation($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function defense()
    {
        $expected = [
            "Black has a decisive material advantage.",
            "White has a significant control of the center.",
            "The black pieces are somewhat better connected.",
            "Black has a significant space advantage.",
            "The white player is pressuring a little bit more squares than its opponent.",
            "White has a total defense advantage.",
            "White has some relative pin advantage.",
        ];

        $board = FenToBoardFactory::create('4q1k1/8/4n3/8/8/4R3/8/6K1 w - -');

        $paragraph = (new FenExplanation($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function discovered_check()
    {
        $expected = [
            "Black has a decisive material advantage.",
            "Black is totally controlling the center.",
            "The black pieces are slightly better connected.",
            "Black has a total space advantage.",
            "Black has some discovered check advantage.",
        ];

        $board = FenToBoardFactory::create('2r5/2n5/5k2/8/8/2K5/8/8 w - - 0 1');

        $paragraph = (new FenExplanation($board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function capablanca_f4()
    {
        $expected = [
            "White is totally controlling the center.",
            "The black pieces are significantly better connected.",
            "White has a total space advantage.",
            "The white player is pressuring a little bit more squares than its opponent.",
            "Overall, 3 heuristic evaluation features are favoring White while 1 is favoring Black.",
        ];

        $board = FenToBoardFactory::create(
            'rnabqkbcnr/pppppppppp/10/10/5P4/10/PPPPP1PPPP/RNABQKBCNR b KQkq f3',
            new CapablancaBoard()
        );

        $paragraph = (new FenExplanation($board, $isEvaluated = true))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }
}
