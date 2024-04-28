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
