<?php

namespace Chess;

use Chess\Variant\Capablanca80\FEN\ShortStrToPgn as Capablanca80FenShortStrToPgn;
use Chess\Variant\Capablanca80\FEN\Field\PiecePlacement as Capablanca80FenFieldPiecePlacement;
use Chess\Variant\Capablanca100\FEN\ShortStrToPgn as Capablanca100FenShortStrToPgn;
use Chess\Variant\Capablanca100\FEN\Field\PiecePlacement as Capablanca100FenFieldPiecePlacement;
use Chess\Variant\Classical\FEN\Field\PiecePlacement as ClassicalFenFieldPiecePlacement;
use Chess\Variant\Classical\FEN\ShortStrToPgn as ClassicalFenShortStrToPgn;
use Chess\Variant\Classical\PGN\AN\Castle;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;

/**
 * FenPlayer.
 *
 * Makes a move in short FEN format.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class FenPlayer
{
    /**
     * Chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    protected Board $board;

    /**
     * Constructor.
     *
     * @param \Chess\Variant\Classical\Board $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    /**
     * Makes a Chess960 move in short FEN format.
     *
     * @param string $fromFen
     * @param string $toShortFen
     * @param string $fromPiecePlacement
     * @param string $toPiecePlacement
     * @return bool true if the move can be made; otherwise false
     */
    public function chess960(
        string $fromFen,
        string $toShortFen,
        string $fromPiecePlacement,
        string $toPiecePlacement
    ): bool {
        return $this->classical(
            $fromFen,
            $toShortFen,
            $fromPiecePlacement,
            $toPiecePlacement
        );
    }

    /**
     * Makes a classical move in short FEN format.
     *
     * @param string $fromFen
     * @param string $toShortFen
     * @param string $fromPiecePlacement
     * @param string $toPiecePlacement
     * @return bool true if the move can be made; otherwise false
     */
    public function classical(
        string $fromFen,
        string $toShortFen,
        string $fromPiecePlacement,
        string $toPiecePlacement
    ): bool {
        ClassicalFenFieldPiecePlacement::validate($fromPiecePlacement);
        ClassicalFenFieldPiecePlacement::validate($toPiecePlacement);

        $fromRanks = explode('/', $fromPiecePlacement);
        $toRanks = explode('/', $toPiecePlacement);

        $castlingRule = $this->board->getCastlingRule();

        $shortFenDist = $castlingRule[Color::W][Piece::K][Castle::SHORT]['fenDist'];
        $longFenDist = $castlingRule[Color::W][Piece::K][Castle::LONG]['fenDist'];
        $shortI = $castlingRule[Color::W][Piece::K][Castle::SHORT]['i'];
        $longI = $castlingRule[Color::W][Piece::K][Castle::LONG]['i'];

        if (
            str_contains($fromRanks[7], "K{$shortFenDist}R") &&
            ClassicalFenFieldPiecePlacement::charPos($toRanks[7], 'K') === $shortI &&
            $this->board->play(Color::W, Castle::SHORT)
        ) {
            return true;
        } elseif (
            str_contains($fromRanks[7], "R{$longFenDist}K") &&
            ClassicalFenFieldPiecePlacement::charPos($toRanks[7], 'K') === $longI &&
            $this->board->play(Color::W, Castle::LONG)
        ) {
            return true;
        } elseif (
            str_contains($fromRanks[0], "k{$shortFenDist}r") &&
            ClassicalFenFieldPiecePlacement::charPos($toRanks[0], 'k') === $shortI &&
            $this->board->play(Color::B, Castle::SHORT)
        ) {
            return true;
        } elseif (
            str_contains($fromRanks[0], "r{$longFenDist}k") &&
            ClassicalFenFieldPiecePlacement::charPos($toRanks[0], 'k') === $longI &&
            $this->board->play(Color::B, Castle::LONG)
        ) {
            return true;
        }

        $pgn = (new ClassicalFenShortStrToPgn($fromFen, $toShortFen))->create();

        return $this->play($pgn);
    }

    /**
     * Makes a Capablanca80 move in short FEN format.
     *
     * @param string $fromFen
     * @param string $toShortFen
     * @param string $fromPiecePlacement
     * @param string $toPiecePlacement
     * @return bool true if the move can be made; otherwise false
     */
    public function capablanca80(
        string $fromFen,
        string $toShortFen,
        string $fromPiecePlacement,
        string $toPiecePlacement
    ): bool {
        Capablanca80FenFieldPiecePlacement::validate($fromPiecePlacement);
        Capablanca80FenFieldPiecePlacement::validate($toPiecePlacement);

        $fromRanks = explode('/', $fromPiecePlacement);
        $toRanks = explode('/', $toPiecePlacement);

        $castlingRule = $this->board->getCastlingRule();

        $shortFenDist = $castlingRule[Color::W][Piece::K][Castle::SHORT]['fenDist'];
        $longFenDist = $castlingRule[Color::W][Piece::K][Castle::LONG]['fenDist'];
        $shortI = $castlingRule[Color::W][Piece::K][Castle::SHORT]['i'];
        $longI = $castlingRule[Color::W][Piece::K][Castle::LONG]['i'];

        if (
            str_contains($fromRanks[7], "K{$shortFenDist}R") &&
            Capablanca80FenFieldPiecePlacement::charPos($toRanks[7], 'K') === $shortI &&
            $this->board->play(Color::W, Castle::SHORT)
        ) {
            return true;
        } elseif (
            str_contains($fromRanks[7], "R{$longFenDist}K") &&
            Capablanca80FenFieldPiecePlacement::charPos($toRanks[7], 'K') === $longI &&
            $this->board->play(Color::W, Castle::LONG)
        ) {
            return true;
        } elseif (
            str_contains($fromRanks[0], "k{$shortFenDist}r") &&
            Capablanca80FenFieldPiecePlacement::charPos($toRanks[0], 'k') === $shortI &&
            $this->board->play(Color::B, Castle::SHORT)
        ) {
            return true;
        } elseif (
            str_contains($fromRanks[0], "r{$longFenDist}k") &&
            Capablanca80FenFieldPiecePlacement::charPos($toRanks[0], 'k') === $longI &&
            $this->board->play(Color::B, Castle::LONG)
        ) {
            return true;
        }

        $pgn = (new Capablanca80FenShortStrToPgn($fromFen, $toShortFen))->create();

        return $this->play($pgn);
    }

    /**
     * Makes a Capablanca100 move in short FEN format.
     *
     * @param string $fromFen
     * @param string $toShortFen
     * @param string $fromPiecePlacement
     * @param string $toPiecePlacement
     * @return bool true if the move can be made; otherwise false
     */
    public function capablanca100(
        string $fromFen,
        string $toShortFen,
        string $fromPiecePlacement,
        string $toPiecePlacement
    ): bool {
        Capablanca100FenFieldPiecePlacement::validate($fromPiecePlacement);
        Capablanca100FenFieldPiecePlacement::validate($toPiecePlacement);

        $fromRanks = explode('/', $fromPiecePlacement);
        $toRanks = explode('/', $toPiecePlacement);

        $castlingRule = $this->board->getCastlingRule();

        $shortFenDist = $castlingRule[Color::W][Piece::K][Castle::SHORT]['fenDist'];
        $longFenDist = $castlingRule[Color::W][Piece::K][Castle::LONG]['fenDist'];
        $shortI = $castlingRule[Color::W][Piece::K][Castle::SHORT]['i'];
        $longI = $castlingRule[Color::W][Piece::K][Castle::LONG]['i'];

        if (
            str_contains($fromRanks[9], "K{$shortFenDist}R") &&
            Capablanca100FenFieldPiecePlacement::charPos($toRanks[9], 'K') === $shortI &&
            $this->board->play(Color::W, Castle::SHORT)
        ) {
            return true;
        } elseif (
            str_contains($fromRanks[9], "R{$longFenDist}K") &&
            Capablanca100FenFieldPiecePlacement::charPos($toRanks[9], 'K') === $longI &&
            $this->board->play(Color::W, Castle::LONG)
        ) {
            return true;
        } elseif (
            str_contains($fromRanks[0], "k{$shortFenDist}r") &&
            Capablanca100FenFieldPiecePlacement::charPos($toRanks[0], 'k') === $shortI &&
            $this->board->play(Color::B, Castle::SHORT)
        ) {
            return true;
        } elseif (
            str_contains($fromRanks[0], "r{$longFenDist}k") &&
            Capablanca100FenFieldPiecePlacement::charPos($toRanks[0], 'k') === $longI &&
            $this->board->play(Color::B, Castle::LONG)
        ) {
            return true;
        }

        $pgn = (new Capablanca100FenShortStrToPgn($fromFen, $toShortFen))->create();

        return $this->play($pgn);
    }

    /**
     * Makes a move in PGN format.
     *
     * @param array $pgn
     * @return bool true if the move can be made; otherwise false
     */
    protected function play(array $pgn): bool
    {
        if ($result = current($pgn)) {
            $color = key($pgn);
            $clone = unserialize(serialize($this->board));
            $clone->play($color, $result);
            $clone->isMate() ? $check = '#' : ($clone->isCheck() ? $check = '+' : $check = '');
            return $this->board->play($color, $result.$check);
        }

        return false;
    }
}
