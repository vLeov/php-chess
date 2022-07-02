<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression;

use Chess\Board;
use Chess\Heuristics;
use Chess\Player;
use Chess\ML\Supervised\Regression\ExpandedFormLabeller;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class ExpandedFormLabellerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start_labelled()
    {
        $board = new Board();

        $balance = (new Heuristics($board->getMovetext()))->getResizedBalance(0, 1);

        $end = end($balance);

        $label = (new ExpandedFormLabeller())->label($end);

        $expected = '5555555555555555555';

        $this->assertSame($expected, $label);
    }

    /**
     * @test
     */
    public function fool_checkmate_labelled()
    {
        $movetext = file_get_contents(self::DATA_FOLDER.'/sample/fool_checkmate.pgn');

        $board = (new Player($movetext))->play()->getBoard();

        $balance = (new Heuristics($board->getMovetext()))->getResizedBalance(0, 1);

        $end = end($balance);

        $label = (new ExpandedFormLabeller())->label($end);

        $expected = '5555555555555001915';

        $this->assertSame($expected, $label);
    }

    /**
     * @test
     */
    public function scholar_checkmate_labelled()
    {
        $movetext = file_get_contents(self::DATA_FOLDER.'/sample/scholar_checkmate.pgn');

        $board = (new Player($movetext))->play()->getBoard();

        $balance = (new Heuristics($board->getMovetext()))->getResizedBalance(0, 1);

        $end = end($balance);

        $label = (new ExpandedFormLabeller())->label($end);

        $expected = '5555555555555087070';

        $this->assertSame($expected, $label);
    }

    /**
     * @test
     */
    public function benko_gambit_labelled()
    {
        $movetext = file_get_contents(self::DATA_FOLDER.'/sample/A59.pgn');

        $board = (new Player($movetext))->play()->getBoard();

        $balance = (new Heuristics($board->getMovetext()))->getResizedBalance(0, 1);

        $end = end($balance);

        $label = (new ExpandedFormLabeller())->label($end);

        $expected = '5555555060555516486';

        $this->assertSame($expected, $label);
    }

    /**
     * @test
     */
    public function open_sicilian_labelled()
    {
        $board = (new OpenSicilian(new Board()))->play();

        $balance = (new Heuristics($board->getMovetext()))->getResizedBalance(0, 1);

        $end = end($balance);

        $label = (new ExpandedFormLabeller())->label($end);

        $expected = '5555555555555527385';

        $this->assertSame($expected, $label);
    }
}
