<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\Heuristic\Picture\Positional as PositionalHeuristicPicture;
use Chess\ML\Supervised\Regression\LinearCombinationLabeller;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\Sicilian\Open as ClosedSicilian;

class LinearCombinationLabellerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 50,
            Symbol::BLACK => 50,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 50,
            Symbol::BLACK => 50,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_Na6()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Na6'));

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 68.5,
            Symbol::BLACK => 31.5,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_Nc6()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 42.5,
            Symbol::BLACK => 57.5,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board()))->play();

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 7.1,
            Symbol::BLACK => 95,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 55.69,
            Symbol::BLACK => 26.52,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 45.62,
            Symbol::BLACK => 57.36,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 27.55,
            Symbol::BLACK => 54.1,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($heuristicPicture, $sample))->label());
    }
}
