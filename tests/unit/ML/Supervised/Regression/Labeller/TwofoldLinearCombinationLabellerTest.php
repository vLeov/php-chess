<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\Heuristic\Picture\Standard as StandardHeuristicPicture;
use Chess\ML\Supervised\Regression\Labeller\TwofoldLinearCombinationLabeller;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\Sicilian\Open as ClosedSicilian;

class TwofoldLinearCombinationLabellerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $heuristicPicture = new StandardHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 0;

        $this->assertEquals($expected, (new TwofoldLinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $heuristicPicture = new StandardHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 0;

        $this->assertEquals($expected, (new TwofoldLinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_Na6()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Na6'));

        $heuristicPicture = new StandardHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 7;

        $this->assertEquals($expected, (new TwofoldLinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function w_e4_b_Nc6()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));

        $heuristicPicture = new StandardHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = -9;

        $this->assertEquals($expected, (new TwofoldLinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board()))->play();

        $heuristicPicture = new StandardHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = -45.9;

        $this->assertEquals($expected, (new TwofoldLinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $heuristicPicture = new StandardHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 15.44;

        $this->assertEquals($expected, (new TwofoldLinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $heuristicPicture = new StandardHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 14.12;

        $this->assertEquals($expected, (new TwofoldLinearCombinationLabeller($heuristicPicture, $sample))->label());
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $heuristicPicture = new StandardHeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 9.45;

        $this->assertEquals($expected, (new TwofoldLinearCombinationLabeller($heuristicPicture, $sample))->label());
    }
}
