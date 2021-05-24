<?php

namespace Chess\Tests\Unit\ML\Supervised\Classification;

use Chess\Board;
use Chess\Combinatorics\RestrictedPermutationWithRepetition;
use Chess\HeuristicPicture;
use Chess\ML\Supervised\Classification\LinearCombinationLabeller;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\Sicilian\Open as ClosedSicilian;

class LinearCombinationLabellerTest extends AbstractUnitTestCase
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

        $label = (new LinearCombinationLabeller(self::$permutations))
            ->label($end);

        $this->assertEquals($expected, $label);
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

        $label = (new LinearCombinationLabeller(self::$permutations))
            ->label($end);

        $this->assertEquals($expected, $label);
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
            Symbol::WHITE => 71,
            Symbol::BLACK => 62,
        ];

        $label = (new LinearCombinationLabeller(self::$permutations))
            ->label($end);

        $this->assertEquals($expected, $label);
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
            Symbol::WHITE => 81,
            Symbol::BLACK => 152,
        ];

        $label = (new LinearCombinationLabeller(self::$permutations))->label($end);

        $this->assertEquals($expected, $label);
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
            Symbol::WHITE => 67,
            Symbol::BLACK => 81,
        ];

        $label = (new LinearCombinationLabeller(self::$permutations))->label($end);

        $this->assertEquals($expected, $label);
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
            Symbol::WHITE => 69,
            Symbol::BLACK => 61,
        ];

        $label = (new LinearCombinationLabeller(self::$permutations))->label($end);

        $this->assertEquals($expected, $label);
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
            Symbol::WHITE => 71,
            Symbol::BLACK => 145,
        ];

        $label = (new LinearCombinationLabeller(self::$permutations))->label($end);

        $this->assertEquals($expected, $label);
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
            Symbol::WHITE => 64,
            Symbol::BLACK => 67,
        ];

        $label = (new LinearCombinationLabeller(self::$permutations))->label($end);

        $this->assertEquals($expected, $label);
    }
}
