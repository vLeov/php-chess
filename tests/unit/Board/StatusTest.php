<?php

namespace PGNChess\Tests\Unit\Board;

use PGNChess\Board;
use PGNChess\Castling\Rule as CastlingRule;
use PGNChess\Opening\Benoni\BenkoGambit;
use PGNChess\Opening\RuyLopez\Exchange as ExchangeRuyLopez;
use PGNChess\Opening\RuyLopez\LucenaDefense as LucenaDefense;
use PGNChess\Opening\RuyLopez\Open as OpenRuyLopez;
use PGNChess\PGN\Move;
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
    public function history_in_lucena_defense()
    {
        $board = (new LucenaDefense(new Board))->play();

        $expected = [
            (object) [
                'position' => 'e2',
                'move' => (object) [
                    'pgn' => 'e4',
                    'isCapture' => false,
                    'isCheck' => false,
                    'type' => Move::PAWN,
                    'color' => Symbol::WHITE,
                    'identity' => Symbol::PAWN,
                    'position' => (object) [
                        'current' => 'e',
                        'next' => 'e4',
                    ],
                ],
            ],
            (object) [
                'position' => 'e7',
                'move' =>  (object) [
                    'pgn' => 'e5',
                    'isCapture' => false,
                    'isCheck' => false,
                    'type' => Move::PAWN,
                    'color' => Symbol::BLACK,
                    'identity' => Symbol::PAWN,
                    'position' => (object) [
                        'current' => 'e',
                        'next' => 'e5',
                    ],
                ],
            ],
            (object) [
                'position' => 'g1',
                'move' => (object) [
                    'pgn' => 'Nf3',
                    'isCapture' => false,
                    'isCheck' => false,
                    'type' => Move::KNIGHT,
                    'color' => Symbol::WHITE,
                    'identity' => Symbol::KNIGHT,
                    'position' => (object) [
                        'current' => null,
                        'next' => 'f3',
                    ],
                ],
            ],
            (object) [
                'position' => 'b8',
                'move' => (object) [
                    'pgn' => 'Nc6',
                    'isCapture' => false,
                    'isCheck' => false,
                    'type' => Move::KNIGHT,
                    'color' => Symbol::BLACK,
                    'identity' => Symbol::KNIGHT,
                    'position' => (object) [
                        'current' => null,
                        'next' => 'c6',
                    ],
                ],
            ],
            (object) [
                'position' => 'f1',
                'move' => (object) [
                    'pgn' => 'Bb5',
                    'isCapture' => false,
                    'isCheck' => false,
                    'type' => Move::PIECE,
                    'color' => Symbol::WHITE,
                    'identity' => Symbol::BISHOP,
                    'position' => (object) [
                        'current' => null,
                        'next' => 'b5',
                    ],
                ],
            ],
            (object) [
                'position' => 'f8',
                'move' => (object) [
                    'pgn' => 'Be7',
                    'isCapture' => false,
                    'isCheck' => false,
                    'type' => Move::PIECE,
                    'color' => Symbol::BLACK,
                    'identity' => Symbol::BISHOP,
                    'position' => (object) [
                        'current' => null,
                        'next' => 'e7',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $board->getHistory());
    }

    /**
     * @test
     */
    public function kings_legal_moves_in_benko_gambit()
    {
        $board = (new BenkoGambit(new Board))->play();

        $king = $board->getPieceByPosition('f1');

        $expected = [ 'e1', 'e2', 'g2' ];

        $this->assertEquals($expected, $king->getLegalMoves());
    }
}
