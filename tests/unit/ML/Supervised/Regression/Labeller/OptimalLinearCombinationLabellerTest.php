<?php

namespace Chess\Tests\Unit\ML\Supervised\Regression\Labeller;

use Chess\Board;
use Chess\Combinatorics\RestrictedPermutationWithRepetition;
use Chess\Heuristic\HeuristicPicture;
use Chess\ML\Supervised\Regression\OptimalLinearCombinationLabeller;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\Sicilian\Open as ClosedSicilian;

class OptimalLinearCombinationLabellerTest extends AbstractUnitTestCase
{
    static $permutations;

    public static function setUpBeforeClass(): void
    {
        $dimensions = (new HeuristicPicture(''))->getDimensions();

        self::$permutations = (new RestrictedPermutationWithRepetition())
            ->get(
                [ 8, 13, 21, 34],
                count($dimensions),
                100
            );
    }

    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());

        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 50,
            Symbol::BLACK => 50,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals(
            $expected[Symbol::WHITE] - $expected[Symbol::BLACK],
            $label[Symbol::WHITE] - $label[Symbol::BLACK],
        );
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

        $expected = [
            Symbol::WHITE => 50,
            Symbol::BLACK => 50,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals(
            $expected[Symbol::WHITE] - $expected[Symbol::BLACK],
            $label[Symbol::WHITE] - $label[Symbol::BLACK],
        );
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

        $expected = [
            Symbol::WHITE => 72,
            Symbol::BLACK => 61.5,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals(
            $expected[Symbol::WHITE] - $expected[Symbol::BLACK],
            $label[Symbol::WHITE] - $label[Symbol::BLACK],
        );
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

        $expected = [
            Symbol::WHITE => 59,
            Symbol::BLACK => 69.5,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals(
            $expected[Symbol::WHITE] - $expected[Symbol::BLACK],
            $label[Symbol::WHITE] - $label[Symbol::BLACK],
        );
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 38.7,
            Symbol::BLACK => 80,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals(
            $expected[Symbol::WHITE] - $expected[Symbol::BLACK],
            $label[Symbol::WHITE] - $label[Symbol::BLACK],
        );
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 66.96,
            Symbol::BLACK => 59.79,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals(
            $expected[Symbol::WHITE] - $expected[Symbol::BLACK],
            $label[Symbol::WHITE] - $label[Symbol::BLACK],
        );
    }

    /**
     * @test
     */
    public function benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 63.52,
            Symbol::BLACK => 55.5,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals(
            $expected[Symbol::WHITE] - $expected[Symbol::BLACK],
            $label[Symbol::WHITE] - $label[Symbol::BLACK],
        );
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 55.21,
            Symbol::BLACK => 43.92,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals(
            $expected[Symbol::WHITE] - $expected[Symbol::BLACK],
            $label[Symbol::WHITE] - $label[Symbol::BLACK],
        );
    }

    /**
     * @test
     */
    public function closed_sicilian_permutation()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [ 8, 8, 34, 13, 13, 8, 8, 8 ];

        $permutation = (new OptimalLinearCombinationLabeller($sample, self::$permutations))
            ->permute(Symbol::BLACK, 43.92);

        $this->assertEquals($expected, $permutation);
    }
}
