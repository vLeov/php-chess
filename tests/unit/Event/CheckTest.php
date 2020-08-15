<?php

namespace PGNChess\Tests\Unit\Evaluation;

use PGNChess\Board;
use PGNChess\Event\Check as CheckEvent;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;
use PGNChess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use PGNChess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;
use PGNChess\Tests\Sample\Opening\RuyLopez\LucenaDefense as RuyLopezLucenaDefense;

class CheckTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board))->play();

        $this->assertEquals(0, (new CheckEvent($board))->capture(Symbol::WHITE));
        $this->assertEquals(1, (new CheckEvent($board))->capture(Symbol::BLACK));
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board))->play();

        $this->assertEquals(1, (new CheckEvent($board))->capture(Symbol::WHITE));
        $this->assertEquals(0, (new CheckEvent($board))->capture(Symbol::BLACK));
    }

    /**
     * @test
     */
    public function ruy_lopez_lucena_defense()
    {
        $board = (new RuyLopezLucenaDefense(new Board))->play();

        $this->assertEquals(0, (new CheckEvent($board))->capture(Symbol::WHITE));
        $this->assertEquals(0, (new CheckEvent($board))->capture(Symbol::BLACK));
    }
}
