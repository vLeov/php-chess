<?php

namespace Chess\Tests\Unit\Variant\Capablanca\Piece;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Piece\K;

class KTest extends AbstractUnitTestCase
{
    static private $size;

    public static function setUpBeforeClass(): void
    {
        self::$size = [
            'files' => 10,
            'ranks' => 10,
        ];
    }

    /**
     * @test
     */
    public function mobility_w_f1()
    {
        $king = new K('w', 'f1', self::$size);

        $mobility = (object) [
            'up' => 'f2',
            'left' => 'e1',
            'right' => 'g1',
            'upLeft' => 'e2',
            'upRight' => 'g2',
        ];

        $this->assertEquals($mobility, $king->getMobility());
    }

    /**
     * @test
     */
    public function mobility_b_f10()
    {
        $king = new K('b', 'f10', self::$size);

        $mobility = (object) [
            'down' => 'f9',
            'left' => 'e10',
            'right' => 'g10',
            'downLeft' => 'e9',
            'downRight' => 'g9',
        ];

        $this->assertEquals($mobility, $king->getMobility());
    }
}
