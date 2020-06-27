<?php

namespace PGNChess\Evaluation\Value;

use PGNChess\PGN\Symbol;

/**
 * System.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class System
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

    private $system;

    public function __construct()
    {
        $this->system = [
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
    }

    public function get()
    {
        return $this->system;
    }
}
