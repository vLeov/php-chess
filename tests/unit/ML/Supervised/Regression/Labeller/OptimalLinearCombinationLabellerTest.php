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
    public function start_labelled()
    {
        $board = new Board();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());

        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 50,
            Symbol::BLACK => 50,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function start_balanced()
    {
        $board = new Board();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());

        $sample = $heuristicPicture->sample();

        $expected = 0;

        $balance = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->balance();

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function w_e4_b_e5_labelled()
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

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function w_e4_b_e5_balanced()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 0;

        $balance = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->balance();

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function w_e4_b_Na6_labelled()
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

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function w_e4_b_Na6_balanced()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Na6'));

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 44;

        $balance = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->balance();

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function w_e4_b_Nc6_labelled()
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

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function w_e4_b_Nc6_balanced()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6'));

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 18;

        $balance = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->balance();

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function fool_checkmate_labelled()
    {
        $board = (new FoolCheckmate(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 38.7,
            Symbol::BLACK => 80,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function fool_checkmate_balanced()
    {
        $board = (new FoolCheckmate(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 0;

        $balance = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->balance();

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function scholar_checkmate_labelled()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 66.96,
            Symbol::BLACK => 59.79,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function scholar_checkmate_balanced()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 38.32;

        $balance = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->balance();

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function benko_gambit_labelled()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 63.52,
            Symbol::BLACK => 55.5,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function benko_gambit_balanced()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 33.72;

        $balance = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->balance();

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function closed_sicilian_labelled()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = [
            Symbol::WHITE => 55.21,
            Symbol::BLACK => 43.92,
        ];

        $label = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->label();

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function closed_sicilian_balanced()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $heuristicPicture = new HeuristicPicture($board->getMovetext());
        $sample = $heuristicPicture->sample();

        $expected = 27.06;

        $balance = (new OptimalLinearCombinationLabeller($sample, self::$permutations))->balance();

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function closed_sicilian_permuted()
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
