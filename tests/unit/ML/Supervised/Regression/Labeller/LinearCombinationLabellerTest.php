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
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 50,
            Symbol::BLACK => 50,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
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
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 50,
            Symbol::BLACK => 50,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
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
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 62.5,
            Symbol::BLACK => 37.5,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
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
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 37.5,
            Symbol::BLACK => 62.5,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board()))->play();

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 11,
            Symbol::BLACK => 90,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 51.05,
            Symbol::BLACK => 37.9,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 43.5,
            Symbol::BLACK => 48,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $heuristicPicture = new PositionalHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 31.2,
            Symbol::BLACK => 51.9,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
    }
}
