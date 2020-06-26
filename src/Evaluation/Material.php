<?php

namespace PGNChess\Evaluation;

use PGNChess\AbstractEvaluation;
use PGNChess\PGN\Symbol;

/**
 * Material.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Material extends AbstractEvaluation
{
    const SYSTEM_BERLINER       = 'SYSTEM_BERLINER';
    const SYSTEM_BILGUER        = 'SYSTEM_BILGUER';
    const SYSTEM_FISHER         = 'SYSTEM_FISHER';
    const SYSTEM_KASPAROV       = 'SYSTEM_KASPAROV';
    const SYSTEM_KAUFMAN        = 'SYSTEM_KAUFMAN';
    const SYSTEM_LASKER         = 'SYSTEM_LASKER';
    const SYSTEM_PHILIDOR       = 'SYSTEM_PHILIDOR';
    const SYSTEM_PRATT          = 'SYSTEM_PRATT';
    const SYSTEM_SARRAT         = 'SYSTEM_SARRAT';

    public function evaluate(string $name): array
    {
        $result = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];

        foreach ($this->board->getPiecesByColor(Symbol::WHITE) as $piece) {
            switch ($piece->getIdentity()) {
                case Symbol::KNIGHT:
                    $result[Symbol::WHITE] += $this->systems($name)[Symbol::KNIGHT];
                    break;
                case Symbol::BISHOP:
                    $result[Symbol::WHITE] += $this->systems($name)[Symbol::BISHOP];
                    break;
                case Symbol::ROOK:
                    $result[Symbol::WHITE] += $this->systems($name)[Symbol::ROOK];
                    break;
                case Symbol::QUEEN:
                    $result[Symbol::WHITE] += $this->systems($name)[Symbol::QUEEN];
                    break;
                case Symbol::KING:
                    isset($this->systems($name)[Symbol::KING])
                        ? $result[Symbol::WHITE] += $this->systems($name)[Symbol::KING]
                        : false;
                    break;
            }
        }

        foreach ($this->board->getPiecesByColor(Symbol::BLACK) as $piece) {
            switch ($piece->getIdentity()) {
                case Symbol::KNIGHT:
                    $result[Symbol::BLACK] += $this->systems($name)[Symbol::KNIGHT];
                    break;
                case Symbol::BISHOP:
                    $result[Symbol::BLACK] += $this->systems($name)[Symbol::BISHOP];
                    break;
                case Symbol::ROOK:
                    $result[Symbol::BLACK] += $this->systems($name)[Symbol::ROOK];
                    break;
                case Symbol::QUEEN:
                    $result[Symbol::BLACK] += $this->systems($name)[Symbol::QUEEN];
                    break;
                case Symbol::KING:
                    isset($this->systems($name)[Symbol::KING])
                        ? $result[Symbol::BLACK] += $this->systems($name)[Symbol::KING]
                        : false;
                    break;
            }
        }

        return $result;
    }

    public function systems(string $name = null)
    {
        $all = [
            self::SYSTEM_BERLINER => [
                Symbol::KNIGHT => 3.2,
                Symbol::BISHOP => 3.33,
                Symbol::ROOK => 5.1,
                Symbol::QUEEN => 8.8,
            ],
            self::SYSTEM_BILGUER => [
                Symbol::KNIGHT => 3.5,
                Symbol::BISHOP => 3.5,
                Symbol::ROOK => 5.7,
                Symbol::QUEEN => 10.3,
            ],
            self::SYSTEM_FISHER => [
                Symbol::KNIGHT => 3,
                Symbol::BISHOP => 3.25,
                Symbol::ROOK => 5,
                Symbol::QUEEN => 9,
            ],
            self::SYSTEM_KASPAROV => [
                Symbol::KNIGHT => 3,
                Symbol::BISHOP => 3,
                Symbol::ROOK => 4.5,
                Symbol::QUEEN => 9,
            ],
            self::SYSTEM_KAUFMAN => [
                Symbol::KNIGHT => 3.25,
                Symbol::BISHOP => 3.25,
                Symbol::ROOK => 5,
                Symbol::QUEEN => 9.75,
            ],
            self::SYSTEM_LASKER => [
                Symbol::KNIGHT => 3,
                Symbol::BISHOP => 3,
                Symbol::ROOK => 5,
                Symbol::QUEEN => 9,
                Symbol::KING => 4,
            ],
            self::SYSTEM_PHILIDOR => [
                Symbol::KNIGHT => 3.05,
                Symbol::BISHOP => 3.50,
                Symbol::ROOK => 5.48,
                Symbol::QUEEN => 9.94,
            ],
            self::SYSTEM_PRATT => [
                Symbol::KNIGHT => 3,
                Symbol::BISHOP => 3,
                Symbol::ROOK => 5,
                Symbol::QUEEN => 10,
            ],
            self::SYSTEM_SARRAT => [
                Symbol::KNIGHT => 3.1,
                Symbol::BISHOP => 3.3,
                Symbol::ROOK => 5,
                Symbol::QUEEN => 7.9,
                Symbol::KING => 2.2,
            ],
        ];

        $system = $all[$name];
        if ($system) {
            return $system;
        }

        return $all;
    }
}
