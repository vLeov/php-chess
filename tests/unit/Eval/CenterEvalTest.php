<?php

namespace Chess\Tests\Unit\Eval;

use Chess\Eval\CenterEval;
use Chess\Play\SanPlay;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Board;

class CenterEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function A08()
    {
        $expectedResult = [
            'w' => 29.4,
            'b' => 33.0,
        ];

        $expectedPhrase = [
            "Black has a significant control of the center.",
        ];

        $A08 = file_get_contents(self::DATA_FOLDER.'/sample/A08.pgn');
        $board = (new SanPlay($A08))->validate()->getBoard();
        $centerEval = new CenterEval($board);

        $this->assertSame($expectedResult, $centerEval->getResult());
        $this->assertSame($expectedPhrase, $centerEval->getExplanation());
    }

    /**
     * @test
     */
    public function B25()
    {
        $expectedResult = [
            'w' => 37.73,
            'b' => 34.73,
        ];

        $expectedPhrase = [
            "White has a significant control of the center.",
        ];

        $B25 = file_get_contents(self::DATA_FOLDER.'/sample/B25.pgn');
        $board = (new SanPlay($B25))->validate()->getBoard();
        $centerEval = new CenterEval($board);

        $this->assertSame($expectedResult, $centerEval->getResult());
        $this->assertSame($expectedPhrase, $centerEval->getExplanation());
    }

    /**
     * @test
     */
    public function B56()
    {
        $expectedResult = [
            'w' => 47.0,
            'b' => 36.8,
        ];

        $expectedPhrase = [
            "White is just controlling the center.",
        ];

        $B56 = file_get_contents(self::DATA_FOLDER.'/sample/B56.pgn');
        $board = (new SanPlay($B56))->validate()->getBoard();
        $centerEval = new CenterEval($board);

        $this->assertSame($expectedResult, $centerEval->getResult());
        $this->assertSame($expectedPhrase, $centerEval->getExplanation());
    }

    /**
     * @test
     */
    public function C60()
    {
        $expectedResult = [
            'w' => 37.73,
            'b' => 34.73,
        ];

        $expectedPhrase = [
            "White has a significant control of the center.",
        ];

        $C60 = file_get_contents(self::DATA_FOLDER.'/sample/C60.pgn');
        $board = (new SanPlay($C60))->validate()->getBoard();
        $centerEval = new CenterEval($board);

        $this->assertSame($expectedResult, $centerEval->getResult());
        $this->assertSame($expectedPhrase, $centerEval->getExplanation());
    }
}
