<?php

namespace PGNChess\Tests\Unit\Board;

use PGNChess\Board;
use PGNChess\Castling\Rule as CastlingRule;
use PGNChess\Opening\RuyLopez\Exchange as ExchangeRuyLopez;
use PGNChess\Opening\RuyLopez\Open as OpenRuyLopez;
use PGNChess\PGN\Convert;
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
    public function kings_legal_moves_when_moved_and_not_castled()
    {
        $kingsLegalMoves = [
            'e8',
            'd7',
            'd8',
            'f8',
            'd6',
            'f6'
        ];

        $board = new Board;

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'e4')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'e6')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'd4')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'd5')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Nc3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Bb4')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Ne2')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Nf6')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'a3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Be7')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'exd5')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Nxd5')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Nxd5')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'exd5')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Ng3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'g6')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Bh6')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Be6')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Bd3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Nc6')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'O-O')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Bf6')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'c3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Ne7')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Qb3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Qc8')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Rae1')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Ng8')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Bc1')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Ne7')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'f4')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Bh4')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'f5')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Bxg3')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'hxg3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'gxf5')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Bg5')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Rg8')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Bxe7')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Kxe7')));

        $king = $board->getPieceByPosition('e7');

        $this->assertEquals($kingsLegalMoves, $king->getLegalMoves());
    }
}
