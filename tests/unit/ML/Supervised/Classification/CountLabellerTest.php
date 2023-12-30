<?php

namespace Chess\Tests\Unit\ML\Supervised\Classification;

use Chess\Heuristics\FenHeuristics;
use Chess\ML\Supervised\Classification\CountLabeller;
use Chess\Tests\AbstractUnitTestCase;

class CountLabellerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4_labelled()
    {
        $fen = 'rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq - 0 1';

        $balance = (new FenHeuristics($fen))->getBalance();

        $label = (new CountLabeller())->label($balance);

        $expected = [
            'w' => 2,
            'b' => 1,
        ];

        $this->assertEquals($expected, $label);
    }
}
