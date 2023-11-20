<?php

namespace Chess\Variant\Classical\Randomizer;

use Chess\Piece\K;
use Chess\Piece\RType;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Rule\CastlingRule;

/**
 * Randomizer.
 *
 * Creates a \Chess\Variant\Classical\Board object with random pieces.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class Randomizer
{
    const FILES = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    const RANKS = ['1', '2', '3', '4', '5', '6', '7', '8'];

    /**
     * Chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    protected Board $board;

    /**
     * Castling rule.
     *
     * @var array
     */
    protected array $castlingRule;

    /**
     * The items to be added.
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Constructor.
     *
     * @param string $turn
     * @param array $items
     */
    public function __construct(string $turn, array $items = [])
    {
        $this->castlingRule = (new CastlingRule())->getRule();

        $this->items = $items;

        do {
            $pieces = $this->kings();
            $pieces = $this->rand($items, $pieces);
            $board = new Board($pieces);
        } while ($this->isAttackingKing($board));

        $this->board = $board->setTurn($turn);
    }

    /**
     * Returns the Chess\Board object.
     *
     * @return \Chess\Variant\Classical\Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * Returns a random square.
     *
     * @return string
     */
    protected function sq(): string
    {
        $files = self::FILES;
        $ranks = self::RANKS;

        shuffle($files);
        shuffle($ranks);

        $file = $files[0];
        $rank = $ranks[0];

        return $file . $rank;
    }

    /**
     * Finds out if two squares are adjacent to each other.
     *
     * @return bool
     */
    protected function areAdjacentSqs(string $w, string $b): bool
    {
        $prev = chr(ord($w) - 1);
        $curr = $w;
        $next = chr(ord($w) + 1);

        return $b === $prev || $b === $curr || $b === $next;
    }

    /**
     * Creates a Chess\Board object with two randomly placed kings.
     *
     * @return array
     */
    protected function kings(): array
    {
        $wSq = $this->sq();
        $wFile = $wSq[0];
        $wRank = $wSq[1];

        do {
            $bSq = $this->sq();
            $bFile = $bSq[0];
            $bRank = $bSq[1];
        } while (
            $this->areAdjacentSqs($wFile, $bFile) &&
            $this->areAdjacentSqs($wRank, $bRank)
        );

        $pieces = [
            new K(Color::W, $wSq, $this->castlingRule),
            new K(Color::B, $bSq, $this->castlingRule),
        ];

        $this->board = new Board($pieces);

        return $pieces;
    }

    /**
     * Adds items randomly to the given array of pieces.
     *
     * @param array $items
     * @param array $pieces
     * @return array
     */
    protected function rand(array $items, array $pieces): array
    {
        $freeSqs = $this->board->getSqCount()->free;
        foreach ($items as $color => $ids) {
            foreach ($ids as $id) {
                $arrayRand = array_rand($freeSqs, 1);
                $sq = $freeSqs[$arrayRand];
                $className = "\Chess\\Piece\\$id";
                $pieces[] = new $className(
                    $color,
                    $sq,
                    $this->board->getSize(),
                    $id !== Piece::R ?: RType::PROMOTED
                );
                unset($freeSqs[$arrayRand]);
            }
        }

        return $pieces;
    }

    /**
     * Finds out if any of the two kings is being attacked.
     *
     * @return bool
     */
    protected function isAttackingKing(Board $board): bool
    {
        foreach ($board->getPieces() as $piece) {
            if ($piece->isAttackingKing()) {
                return true;
            }
        }

        return false;
    }
}
