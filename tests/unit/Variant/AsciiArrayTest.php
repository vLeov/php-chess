<?php

namespace Chess\Tests\Unit\Variant;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\AsciiArray;
use Chess\Variant\Classical\PGN\AN\Square;
use Chess\Variant\Classical\Rule\CastlingRule;

class AsciiArrayTest extends AbstractUnitTestCase
{
    static private Square $square;

    static private CastlingRule $castlingRule;

    public static function setUpBeforeClass(): void
    {
        self::$square = new Square();

        self::$castlingRule = new CastlingRule();
    }

    /**
     * @test
     */
    public function set_elem_e4_e5()
    {
        $array = [
            7 => [ ' r ', ' n ', ' b ', ' q ', ' k ', ' b ', ' n ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' B ', ' Q ', ' K ', ' B ', ' N ', ' R ' ],
        ];

        $expected = [
            7 => [ ' r ', ' n ', ' b ', ' q ', ' k ', ' b ', ' n ', ' r ' ],
            6 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ' ],
            5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' N ', ' . ', ' . ' ],
            1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ' ],
            0 => [ ' R ', ' N ', ' B ', ' Q ', ' K ', ' B ', ' . ', ' R ' ],
        ];

        $array = (new AsciiArray($array, self::$square, self::$castlingRule->rule))
            ->setElem(' . ', 'g1')
            ->setElem(' N ', 'f3')
            ->getArray();

        $this->assertSame($expected, $array);
    }

    /**
     * @test
     */
    public function from_index_to_algebraic_0_0()
    {
        $this->assertSame('a1', AsciiArray::toAlgebraic(0, 0));
    }

    /**
     * @test
     */
    public function from_index_to_algebraic_0_7()
    {
        $this->assertSame('a8', AsciiArray::toAlgebraic(0, 7));
    }

    /**
     * @test
     */
    public function from_index_to_algebraic_0_8()
    {
        $this->assertSame('a9', AsciiArray::toAlgebraic(0, 8));
    }
}
