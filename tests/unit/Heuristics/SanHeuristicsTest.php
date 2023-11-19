<?php

namespace Chess\Tests\Unit;

use Chess\Heuristics\SanHeuristics;
use Chess\Play\SanPlay;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\FEN\StrToBoard;

class SanHeuristicsTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function get_balance_start()
    {
        $board = new Board();

        $balance = (new SanHeuristics($board->getMovetext()))->getBalance();

        $expected = [
            [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
        ];

        $this->assertSame($expected, $balance);
    }

    /**
     * @test
     */
    public function get_balance_e4()
    {
        $movetext = '1.e4';

        $balance = (new SanHeuristics($movetext))->getBalance();

        $expected = [
            [ 0, 0.0, 1.0, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 1.0, 0.0, 1.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
        ];

        $this->assertSame($expected, $balance);
    }

    /**
     * @test
     */
    public function get_balance_e4_e5()
    {
        $movetext = '1.e4 e5';

        $balance = (new SanHeuristics($movetext))->getBalance();

        $expected = [
            [ 0, 0.0, 1.0, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 1.0, 0.0, 1.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0.0, 1.0, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
        ];

        $this->assertSame($expected, $balance);
    }

    /**
     * @test
     */
    public function get_balance_e4_e6()
    {
        $movetext = '1.e4 e6';

        $balance = (new SanHeuristics($movetext))->getBalance();

        $expected = [
            [ 0, 0.0, 1.0, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 1.0, 0.0, 1.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0.25, 0.5, 0.13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
        ];

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function get_balance_e4_e6_d4_d5()
    {
        $movetext = '1.e4 e6 2.d4 d5';

        $balance = (new SanHeuristics($movetext))->getBalance();

        $expected = [
            [ 0, 0.0, 1.0, 0.0, 0, 0, 1.0, 0, 0, 0, 0, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0.86, 0.2, 1.0, 0, 0, 1.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0.21, 0.6, 0.13, 0, 0, 1.0, 0, 0, 0, 0, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 1.0, 0.0, 0.88, 0, 0, 1.0, 0, 0, 0, 0, 1.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0.64, 0.4, 0.63, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
        ];

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function get_balance_e4_e6_d4_d5_Nd2_Nf6()
    {
        $movetext = '1.e4 e6 2.d4 d5 3.Nd2 Nf6';

        $balance = (new SanHeuristics($movetext))->getBalance();

        $expected = [
            [ 0, 0.0, 0.83, 0.0, 1.0, 0, 1.0, 0, 0, 0, 0, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0.86, 0.17, 1.0, 1.0, 0, 1.0, 0, 0, 0, 0, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0.21, 0.5, 0.13, 1.0, 0, 1.0, 0, 0, 0, 0, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 1, 0.0, 0.88, 1.0, 0, 1.0, 0, 0, 0, 0, 1.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0.64, 0.33, 0.63, 1.0, 0, 0.5, 0, 0, 0, 0, 1.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0.59, 1.0, 0.25, 1.0, 0, 1.0, 0, 0, 0, 0, 1.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0.27, 0.17, 0.25, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
        ];

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function get_balance_A00()
    {
        $A00 = file_get_contents(self::DATA_FOLDER.'/sample/A00.pgn');

        $board = (new SanPlay($A00))->validate()->getBoard();

        $balance = (new SanHeuristics($board->getMovetext()))->getBalance();

        $expected = [
            [ 0, 0.67, 0, 0.8, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 1, 0.22, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0, 0.67, 0.2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0.17, 0.56, 0.4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
            [ 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
        ];

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function get_balance_scholar_checkmate()
    {
        $movetext = file_get_contents(self::DATA_FOLDER.'/sample/scholar_checkmate.pgn');

        $board = (new SanPlay($movetext))->validate()->getBoard();

        $balance = (new SanHeuristics($board->getMovetext()))->getBalance();

        $expected = [
            [ 0, 0.21, 1, 0, 0, 0, 0.8, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0 ],
            [ 0, 1, 0.71, 1, 0, 0, 0.8, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0 ],
            [ 0, 0.21, 1, 0, 0, 0, 0.8, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0 ],
            [ 0, 0.65, 0.93, 0.13, 0.25, 0.25, 0.8, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0 ],
            [ 0, 0.36, 0.64, 0, 0.25, 0.25, 0.8, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0 ],
            [ 0, 0.49, 0.36, 0.5, 1, 0.25, 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 1, 0 ],
            [ 0, 0, 0, 0.5, 0.5, 0.25, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0 ],
            [ 1, 0.58, 0.14, 0.25, 0.75, 1, 0.69, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0 ],
        ];

        $this->assertEquals($expected, $balance);
    }
}
