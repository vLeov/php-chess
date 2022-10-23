<?php

namespace Chess\Tests\Unit\UciEngine;

use Chess\UciEngine\Stockfish;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Board;

class StockfishTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function bestMove()
    {
        $board = new Board();
        $board->play('w', 'e4');
        $stockfish = (new Stockfish($board))
            ->setOptions([
                'Skill Level' => 9
            ])
            ->setParams([
                'depth' => 3
            ]);

        $fromFen = $board->toFen();
        $toFen = $stockfish->bestMove($fromFen);

        $this->assertNotEmpty($toFen);
    }

    /**
     * @test
     */
    public function play_e4()
    {
        $board = new Board();
        $board->play('w', 'e4');

        $stockfish = (new Stockfish($board))
            ->setOptions([
                'Skill Level' => 17
            ])
            ->setParams([
                'depth' => 8
            ]);

        $uci = $stockfish->play($board->toFen());

        $this->assertTrue($board->playLan('b', $uci));
        $this->assertTrue($board->playLan('w', 'a2a3'));

        $uci = $stockfish->play($board->toFen());

        $this->assertTrue($board->playLan('b', $uci));
    }

    /**
     * @test
     */
    public function play_Na3()
    {
        $board = new Board();
        $board->play('w', 'Na3');

        $stockfish = (new Stockfish($board))
            ->setOptions([
                'Skill Level' => 17
            ])
            ->setParams([
                'depth' => 8
            ]);

        $uci = $stockfish->play($board->toFen());
        $this->assertTrue($board->playLan('b', $uci));
        $this->assertTrue($board->playLan('w', 'g1h3'));

        $uci = $stockfish->play($board->toFen());
        $this->assertTrue($board->playLan('b', $uci));
        $this->assertTrue($board->playLan('w', 'a1b1'));

        $uci = $stockfish->play($board->toFen());
        $this->assertTrue($board->playLan('b', $uci));
    }
}
