<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\Heuristic\HeuristicPicture;
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

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
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

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
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

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 55,
            Symbol::BLACK => 45,
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

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 40,
            Symbol::BLACK => 60,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 16,
            Symbol::BLACK => 75,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 48.7,
            Symbol::BLACK => 43.3,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 46.3,
            Symbol::BLACK => 28,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();
        $weights = array_values($heuristicPicture->getDimensions());

        $expected = [
            Symbol::WHITE => 36.7,
            Symbol::BLACK => 23.6,
        ];

        $this->assertEquals($expected, (new LinearCombinationLabeller($sample, $weights))->label());
    }
}
