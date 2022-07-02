<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression;

use Chess\Board;
use Chess\Heuristics;
use Chess\Player;
use Chess\ML\Supervised\Regression\GeometricSumLabeller;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class GeometricSumLabellerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start_labelled()
    {
        $board = new Board();

        $balance = (new Heuristics($board->getMovetext()))->getBalance();

        $end = end($balance);

        $label = (new GeometricSumLabeller())->label($end);

        $expected = 0.0;

        $this->assertSame($expected, $label);
    }

    /**
     * @test
     */
    public function fool_checkmate_labelled()
    {
        $movetext = file_get_contents(self::DATA_FOLDER.'/sample/fool_checkmate.pgn');

        $board = (new Player($movetext))->play()->getBoard();

        $balance = (new Heuristics($board->getMovetext()))->getBalance();

        $end = end($balance);

        $label = (new GeometricSumLabeller())->label($end);

        $expected = -52.4;

        $this->assertSame($expected, $label);
    }

    /**
     * @test
     */
    public function scholar_checkmate_labelled()
    {
        $movetext = file_get_contents(self::DATA_FOLDER.'/sample/scholar_checkmate.pgn');

        $board = (new Player($movetext))->play()->getBoard();

        $balance = (new Heuristics($board->getMovetext()))->getBalance();

        $end = end($balance);

        $label = (new GeometricSumLabeller())->label($end);

        $expected = 36.64;

        $this->assertSame($expected, $label);
    }

    /**
     * @test
     */
    public function benko_gambit_labelled()
    {
        $movetext = file_get_contents(self::DATA_FOLDER.'/sample/A59.pgn');

        $board = (new Player($movetext))->play()->getBoard();

        $balance = (new Heuristics($board->getMovetext()))->getBalance();

        $end = end($balance);

        $label = (new GeometricSumLabeller())->label($end);

        $expected = -1544.35;

        $this->assertSame($expected, $label);
    }

    /**
     * @test
     */
    public function open_sicilian_labelled()
    {
        $board = (new OpenSicilian(new Board()))->play();

        $balance = (new Heuristics($board->getMovetext()))->getBalance();

        $end = end($balance);

        $label = (new GeometricSumLabeller())->label($end);

        $expected = -3.22;

        $this->assertSame($expected, $label);
    }
}
