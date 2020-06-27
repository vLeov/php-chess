<?php

namespace PGNChess\Tests\Unit\Board;

use PGNChess\Board;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Piece\Bishop;
use PGNChess\Piece\King;
use PGNChess\Piece\Knight;
use PGNChess\Piece\Pawn;
use PGNChess\Piece\Queen;
use PGNChess\Piece\Rook;
use PGNChess\Type\RookType;
use PGNChess\Tests\AbstractUnitTestCase;

class StatusTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function play_some_moves_and_check_castling()
    {
        $board = new Board;

        $board->play(Convert::toStdObj(Symbol::WHITE, 'd4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'c6'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Bf4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'd5'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Nc3'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nf6'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Bxb8'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Rxb8'));

        $castling = (object) [
            'w' => (object) [
                'castled' => false,
                'O-O' => true,
                'O-O-O' => true
            ],
            'b' => (object) [
                'castled' => false,
                'O-O' => true,
                'O-O-O' => false
            ]
        ];

        $this->assertEquals($castling, $board->getCastling());
    }

    /**
     * @test
     */
    public function captures()
    {
        $captures= [
            'w' => [
                (object) [
                    'capturing' => (object) [
                        'identity' => 'P',
                        'position' => 'b2',
                    ],
                    'captured' => (object) [
                        'identity' => 'B',
                        'position' => 'c3',
                    ],
                ],
                (object) [
                    'capturing' => (object) [
                        'identity' => 'P',
                        'position' => 'e5',
                    ],
                    'captured' => (object) [
                        'identity' => 'P',
                        'position' => 'f5',
                    ],
                ],
                (object) [
                    'capturing' => (object) [
                        'identity' => 'P',
                        'position' => 'd4',
                    ],
                    'captured' => (object) [
                        'identity' => 'P',
                        'position' => 'c5',
                    ],
                ],
            ],
            'b' => [
                (object) [
                    'capturing' => (object) [
                        'identity' => 'B',
                        'position' => 'b4',
                    ],
                    'captured' => (object) [
                        'identity' => 'N',
                        'position' => 'c3',
                    ],
                ],
                (object) [
                    'capturing' => (object) [
                        'identity' => 'R',
                        'position' => 'f8',
                        'type' => 1,
                    ],
                    'captured' => (object) [
                        'identity' => 'P',
                        'position' => 'f6',
                    ],
                ],
            ],
        ];

        $board = new Board;

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'e4')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'e6')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'd4')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'd5')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Nc3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Bb4')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'e5')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'c5')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Qg4')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Ne7')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Nf3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Nbc6')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'a3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Bxc3')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'bxc3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Qc7')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Rb1')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'O-O')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Bd3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'f5')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'exf6')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Rxf6')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Qh3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'g6')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Qh4')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Rf7')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Qg3')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Qa5')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'Ng5')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'Rg7')));

        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::WHITE, 'dxc5')));
        $this->assertEquals(true, $board->play(Convert::toStdObj(Symbol::BLACK, 'e5')));

        $this->assertEquals($captures, $board->getCaptures());
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
