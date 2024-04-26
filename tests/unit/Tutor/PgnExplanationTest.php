<?php

namespace Chess\Tests\Unit\Tutor;

use Chess\FenToBoardFactory;
use Chess\Play\SanPlay;
use Chess\Tutor\PgnExplanation;
use Chess\Tests\AbstractUnitTestCase;

class PgnExplanationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function A08()
    {
        $expected = [
            "Black has a kind of space advantage.",
            "White has a small protection advantage.",
        ];

        $A08 = file_get_contents(self::DATA_FOLDER.'/sample/A08.pgn');
        $board = (new SanPlay($A08))->validate()->getBoard();

        $paragraph = (new PgnExplanation('d4', $board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function endgame()
    {
        $expected = [
            "White has a decisive material advantage.",
            "White is totally controlling the center.",
            "White has a total space advantage.",
            "The white pieces are timidly approaching the other side's king.",
            "Black has a significant protection advantage.",
        ];

        $board = FenToBoardFactory::create('8/5k2/4n3/8/8/1BK5/1B6/8 w - - 0 1');

        $paragraph = (new PgnExplanation('Bxe6+', $board))->getParagraph();

        $this->assertSame($expected, $paragraph);
    }

    /**
     * @test
     */
    public function evaluated_endgame()
    {
        $expected = [
            "White has a decisive material advantage.",
            "White is totally controlling the center.",
            "White has a total space advantage.",
            "The white pieces are timidly approaching the other side's king.",
            "Black has a significant protection advantage.",
            "Overall, 6 heuristic evaluation features are favoring White while 1 is favoring Black.",
        ];

        $board = FenToBoardFactory::create('8/5k2/4n3/8/8/1BK5/1B6/8 w - - 0 1');

        $paragraph = (new PgnExplanation('Bxe6+',
            $board,
            $isEvaluated = true)
        )->getParagraph();

        $this->assertSame($expected, $paragraph);
    }
}
