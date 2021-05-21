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

        $end = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => 50,
            Symbol::BLACK => 50,
        ];

        $label = (new OptimalLinearCombinationLabeller(self::$permutations))
            ->label($end);

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function start_balanced()
    {
        $board = new Board();

        $end = (new HeuristicPicture($board->getMovetext()))
            ->takeBalanced()
            ->end();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $balance = (new OptimalLinearCombinationLabeller(self::$permutations))->balance($end);

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

        $end = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => 50,
            Symbol::BLACK => 50,
        ];

        $label = (new OptimalLinearCombinationLabeller(self::$permutations))
            ->label($end);

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

        $end = (new HeuristicPicture($board->getMovetext()))
            ->takeBalanced()
            ->end();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        $balance = (new OptimalLinearCombinationLabeller(self::$permutations))->balance($end);

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

        $end = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => 72,
            Symbol::BLACK => 61.5,
        ];

        $label = (new OptimalLinearCombinationLabeller(self::$permutations))
            ->label($end);

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

        $end = (new HeuristicPicture($board->getMovetext()))
            ->takeBalanced()
            ->end();

        $expected = [
            Symbol::WHITE => 44,
            Symbol::BLACK => -23,
        ];

        $balance = (new OptimalLinearCombinationLabeller(self::$permutations))->balance($end);

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

        $end = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => 59,
            Symbol::BLACK => 69.5,
        ];

        $label = (new OptimalLinearCombinationLabeller(self::$permutations))->label($end);

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

        $end = (new HeuristicPicture($board->getMovetext()))
            ->takeBalanced()
            ->end();

        $expected = [
            Symbol::WHITE => 18,
            Symbol::BLACK => -39,
        ];

        $balance = (new OptimalLinearCombinationLabeller(self::$permutations))->balance($end);

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function fool_checkmate_labelled()
    {
        $board = (new FoolCheckmate(new Board()))->play();

        $end = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => 38.7,
            Symbol::BLACK => 80,
        ];

        $label = (new OptimalLinearCombinationLabeller(self::$permutations))->label($end);

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function fool_checkmate_balanced()
    {
        $board = (new FoolCheckmate(new Board()))->play();

        $end = (new HeuristicPicture($board->getMovetext()))
            ->takeBalanced()
            ->end();

        $expected = [
            Symbol::WHITE => 0,
            Symbol::BLACK => -67.2,
        ];

        $balance = (new OptimalLinearCombinationLabeller(self::$permutations))->balance($end);

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function scholar_checkmate_labelled()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $end = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => 66.96,
            Symbol::BLACK => 59.79,
        ];

        $label = (new OptimalLinearCombinationLabeller(self::$permutations))->label($end);

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function scholar_checkmate_balanced()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $end = (new HeuristicPicture($board->getMovetext()))
            ->takeBalanced()
            ->end();

        $expected = [
            Symbol::WHITE => 38.32,
            Symbol::BLACK => -28.48,
        ];

        $balance = (new OptimalLinearCombinationLabeller(self::$permutations))->balance($end);

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function benko_gambit_labelled()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $end = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => 63.52,
            Symbol::BLACK => 55.5,
        ];

        $label = (new OptimalLinearCombinationLabeller(self::$permutations))->label($end);

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function benko_gambit_balanced()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $end = (new HeuristicPicture($board->getMovetext()))
            ->takeBalanced()
            ->end();

        $expected = [
            Symbol::WHITE => 33.72,
            Symbol::BLACK => -15.03,
        ];

        $balance = (new OptimalLinearCombinationLabeller(self::$permutations))->balance($end);

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function closed_sicilian_labelled()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $end = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => 55.21,
            Symbol::BLACK => 43.92,
        ];

        $label = (new OptimalLinearCombinationLabeller(self::$permutations))->label($end);

        $this->assertEquals($expected, $label);
    }

    /**
     * @test
     */
    public function closed_sicilian_balanced()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $end = (new HeuristicPicture($board->getMovetext()))
            ->takeBalanced()
            ->end();

        $expected = [
            Symbol::WHITE => 27.06,
            Symbol::BLACK => -10.05,
        ];

        $balance = (new OptimalLinearCombinationLabeller(self::$permutations))->balance($end);

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function closed_sicilian_permuted()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $end = (new HeuristicPicture($board->getMovetext()))->take()->end();

        $expected = [ 8, 8, 34, 13, 13, 8, 8, 8 ];

        $permutation = (new OptimalLinearCombinationLabeller(self::$permutations))
            ->permute($end, Symbol::BLACK, 43.92);

        $this->assertEquals($expected, $permutation);
    }
}
