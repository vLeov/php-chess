<?php

namespace PGNChess\Tests\Unit\Stats;

use PGNChess\Board;
use PGNChess\PGN\Convert;
use PGNChess\PGN\Symbol;
use PGNChess\Piece\Bishop;
use PGNChess\Piece\King;
use PGNChess\Piece\Knight;
use PGNChess\Piece\Pawn;
use PGNChess\Piece\Queen;
use PGNChess\Piece\Rook;
use PGNChess\Piece\Type\RookType;
use PGNChess\Stats\Square as StatsSquare;
use PGNChess\Tests\AbstractUnitTestCase;

class SquareTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function castling_after_Rh1()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'd5'),
            new Pawn(Symbol::WHITE, 'e4'),
            new Pawn(Symbol::WHITE, 'f3'),
            new Pawn(Symbol::WHITE, 'g2'),
            new Pawn(Symbol::WHITE, 'h2'),
            new Rook(Symbol::WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'e1'),
            new Rook(Symbol::WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'e8'),
            new Bishop(Symbol::BLACK, 'f8'),
            new Knight(Symbol::BLACK, 'g8'),
            new Rook(Symbol::BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::BLACK, 'f7'),
            new Pawn(Symbol::BLACK, 'g7'),
            new Pawn(Symbol::BLACK, 'h7')
        ];

        $castling = (object) [
            Symbol::WHITE => (object) [
                'castled' => false,
                Symbol::CASTLING_SHORT => true,
                Symbol::CASTLING_LONG => true
            ],
            Symbol::BLACK => (object) [
                'castled' => false,
                Symbol::CASTLING_SHORT => true,
                Symbol::CASTLING_LONG => false
            ]
        ];

        $board = new Board($pieces, $castling);

        $board->play(Convert::toStdObj(Symbol::WHITE, 'Rg1'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nf6'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'Rh1'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'Nd7'));
        $board->play(Convert::toStdObj(Symbol::WHITE, 'O-O')); // this won't be run
        $board->play(Convert::toStdObj(Symbol::WHITE, 'O-O-O')); // this will be run

        $whiteSquaresUsed = [
            'a2',
            'd5',
            'e4',
            'f3',
            'g2',
            'h2',
            'h1',
            'c1',
            'd1'
        ];

        $whiteSpace = [
            'd2', // rook
            'd3',
            'd4',
            'e1',
            'f1',
            'g1',
            'b3', // pawns
            'c6',
            'e6',
            'f5',
            'g4',
            'g3',
            'h3',
            'b1', // king
            'b2',
            'c2',
            'd2',
            'e1', // rook
            'f1',
            'g1'
        ];

        $whiteSpace = array_filter(array_unique($whiteSpace));
        sort($whiteSpace);
        $whiteAttack = [];

        $stats = new StatsSquare($board);

        $this->assertEquals($whiteSquaresUsed, $stats->squares()->used->w);
        $this->assertEquals($whiteSpace, $stats->control()->space->w);
        $this->assertEquals($whiteAttack, $stats->control()->attack->w);
    }

    /**
     * @test
     */
    public function count_squares_in_new_board()
    {
        $board = new Board;
        $stats = new StatsSquare($board);

        $this->assertEquals(count($board), 32);
        $this->assertEquals(count($stats->squares()->used->w), 16);
        $this->assertEquals(count($stats->squares()->used->b), 16);
    }

    /**
     * @test
     */
    public function count_squares_in_custom_board()
    {
        $pieces = [
            new Bishop(Symbol::WHITE, 'c1'),
            new Queen(Symbol::WHITE, 'd1'),
            new King(Symbol::WHITE, 'e1'),
            new Pawn(Symbol::WHITE, 'e2'),
            new King(Symbol::BLACK, 'e8'),
            new Bishop(Symbol::BLACK, 'f8'),
            new Knight(Symbol::BLACK, 'g8')
        ];

        $castling = (object) [
            'w' => (object) [
                'castled' => false,
                'O-O' => false,
                'O-O-O' => false
            ],
            'b' => (object) [
                'castled' => false,
                'O-O' => false,
                'O-O-O' => false
            ]
        ];

        $board = new Board($pieces, $castling);
        $stats = new StatsSquare($board);

        $this->assertEquals(count($board), 7);
        $this->assertEquals(count($stats->squares()->used->w), 4);
        $this->assertEquals(count($stats->squares()->used->b), 3);
    }

    /**
     * @test
     */
    public function play_some_moves_and_check_space()
    {
        $game = [
            'e4 e5',
            'f4 exf4',
            'd4 Nf6',
            'Nc3 Bb4',
            'Bxf4 Bxc3+'
        ];

        $board = new Board;

        foreach ($game as $entry)
        {
            $moves = explode(' ', $entry);
            $board->play(Convert::toStdObj(Symbol::WHITE, $moves[0]));
            $board->play(Convert::toStdObj(Symbol::BLACK, $moves[1]));
        }

        $space = (object) [
            'w' => [
                'a3',
                'a6',
                'b1',
                'b3',
                'b5',
                'c1',
                'c4',
                'c5',
                'd2',
                'd3',
                'd5',
                'd6',
                'e2',
                'e3',
                'e5',
                'f2',
                'f3',
                'f5',
                'g3',
                'g4',
                'g5',
                'h3',
                'h5',
                'h6'
            ],
            'b' => [
                'a5',
                'a6',
                'b4',
                'b6',
                'c6',
                'd2',
                'd5',
                'd6',
                'e6',
                'e7',
                'f8',
                'g4',
                'g6',
                'g8',
                'h5',
                'h6'
            ]
        ];

        $stats = new StatsSquare($board);

        $this->assertEquals($space, $stats->control()->space);
    }
}
