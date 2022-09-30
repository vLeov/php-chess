<?php

namespace Chess\Tests\Unit\Variant\Classical\Piece;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Piece\N;

class NTest extends AbstractUnitTestCase
{
    static private $size;

    public static function setUpBeforeClass(): void
    {
        self::$size = [
            'files' => 8,
            'ranks' => 8,
        ];
    }

    /**
     * @test
     */
    public function mobility_d4()
    {
        $knight = new N('w', 'd4', self::$size);
        $mobility = [
            'c6',
            'b5',
            'b3',
            'c2',
            'e2',
            'f3',
            'f5',
            'e6'
        ];

        $this->assertSame($mobility, $knight->getMobility());
    }

    /**
     * @test
     */
    public function mobility_h1()
    {
        $knight = new N('w', 'h1', self::$size);
        $mobility = [
            'g3',
            'f2'
        ];

        $this->assertSame($mobility, $knight->getMobility());
    }

    /**
     * @test
     */
    public function mobility_b1()
    {
        $knight = new N('w', 'b1', self::$size);
        $mobility = [
            'a3',
            'd2',
            'c3'
        ];

        $this->assertSame($mobility, $knight->getMobility());
    }
}
