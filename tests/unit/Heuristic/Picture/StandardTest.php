<?php

namespace PGNChess\Tests\Unit\Heuristic\Picture;

use PGNChess\Board;
use PGNChess\Heuristic\Picture\Standard as StandardHeuristicPicture;;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Sample\Opening\Benoni\BenkoGambit;

class PictureTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function take()
    {
        $movetext = (new BenkoGambit(new Board))
                        ->play()
                        ->getMovetext();

        $picture = (new StandardHeuristicPicture($movetext))->take();

        $expected = [
            Symbol::WHITE => [
                [0, 0.54, 0, 1, 1],
                [0.25, 0.54, 1, 1, 1],
                [0.25, 0.62, 0, 1, 1],
                [0.25, 0.54, 0, 1, 1],
                [0, 0.46, 0, 0.5, 0.81],
                [0, 0.62, 1, 0.5, 0.81],
                [0.25, 0, 1, 0, 0.19],
                [0, 0.08, 1, 1, 0.19],
                [0, 0.15, 1, 1, 0.19],
            ],
            Symbol::BLACK => [
                [0, 0.92, 0, 1, 1],
                [0.25, 0.92, 0, 1, 1],
                [0.5, 0.85, 0, 1, 1],
                [0.5, 1, 0, 1, 0.81],
                [0.5, 0.62, 0, 1, 0.62],
                [0.5, 0.62, 1, 1, 0.62],
                [1, 0.46, 0, 1, 0.62],
                [0.75, 0.46, 0, 1, 0],
                [0.75, 0.46, 0, 1, 0],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }
}
