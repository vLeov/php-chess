<?php

namespace PGNChess\Tests\Unit\Board;

use PGNChess\Board;
use PGNChess\Castling\Rule as CastlingRule;
use PGNChess\Opening\Benoni\BenkoGambit;
use PGNChess\Opening\RuyLopez\Exchange as ExchangeRuyLopez;
use PGNChess\Opening\RuyLopez\Open as OpenRuyLopez;
use PGNChess\PGN\Symbol;
use PGNChess\Tests\AbstractUnitTestCase;

class StatusTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function castling_in_open_ruy_lopez()
    {
        $board = (new OpenRuyLopez(new Board))->play();

        $expected = [
            'w' => [
                CastlingRule::IS_CASTLED => true,
                Symbol::CASTLING_SHORT => false,
                Symbol::CASTLING_LONG => false,
            ],
            'b' => [
                CastlingRule::IS_CASTLED => false,
                Symbol::CASTLING_SHORT => true,
                Symbol::CASTLING_LONG => true,
            ],
        ];

        $this->assertEquals($expected, $board->getCastling());
    }

    /**
     * @test
     */
    public function captures_in_exchange_ruy_lopez()
    {
        $board = (new ExchangeRuyLopez(new Board))->play();

        $expected = [
            'w' => [
                (object) [
                    'capturing' => (object) [
                        'identity' => 'B',
                        'position' => 'b5',
                    ],
                    'captured' => (object) [
                        'identity' => 'N',
                        'position' => 'c6',
                    ],
                ],
                (object) [
                    'capturing' => (object) [
                        'identity' => 'Q',
                        'position' => 'd1',
                    ],
                    'captured' => (object) [
                        'identity' => 'P',
                        'position' => 'd4',
                    ],
                ],
                (object) [
                    'capturing' => (object) [
                        'identity' => 'N',
                        'position' => 'f3',
                    ],
                    'captured' => (object) [
                        'identity' => 'Q',
                        'position' => 'd4',
                    ],
                ],
            ],
            'b' => [
                (object) [
                    'capturing' => (object) [
                        'identity' => 'P',
                        'position' => 'd7',
                    ],
                    'captured' => (object) [
                        'identity' => 'B',
                        'position' => 'c6',
                    ],
                ],
                (object) [
                    'capturing' => (object) [
                        'identity' => 'P',
                        'position' => 'e5',
                    ],
                    'captured' => (object) [
                        'identity' => 'P',
                        'position' => 'd4',
                    ],
                ],
                (object) [
                    'capturing' => (object) [
                        'identity' => 'Q',
                        'position' => 'd8',
                    ],
                    'captured' => (object) [
                        'identity' => 'Q',
                        'position' => 'd4',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $board->getCaptures());
    }

    /**
     * @test
     */
    public function kings_legal_moves_in_benko_gambit()
    {
        $expected = [ 'e1', 'e2', 'g2' ];

        $board = (new BenkoGambit(new Board))->play();

        $king = $board->getPieceByPosition('f1');

        $this->assertEquals($expected, $king->getLegalMoves());
    }
}
