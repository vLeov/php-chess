<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression;

use Chess\Board;
use Chess\Heuristics;
use Chess\ML\Supervised\Regression\ExpandedFormLabeller;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
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
        $board = (new FoolCheckmate(new Board()))->play();

        $balance = (new Heuristics($board->getMovetext()))->getResizedBalance(0, 1);

        $end = end($balance);

        $label = (new ExpandedFormLabeller())->label($end);

        $expected = '5555550555555001915';

        $this->assertSame($expected, $label);
    }

    /**
     * @test
     */
    public function scholar_checkmate_labelled()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $balance = (new Heuristics($board->getMovetext()))->getResizedBalance(0, 1);

        $end = end($balance);

        $label = (new ExpandedFormLabeller())->label($end);

        $expected = '5555560555555087070';

        $this->assertSame($expected, $label);
    }

    /**
     * @test
     */
    public function benko_gambit_labelled()
    {
        $board = (new BenkoGambit(new Board()))->play();

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
