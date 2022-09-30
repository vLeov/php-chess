<?php

namespace Chess\Tests\Unit\Variant\Capablanca\Piece;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Piece\A;

class ATest extends AbstractUnitTestCase
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
    public function mobility_a1()
    {
        $archbishop = new A('w', 'a1', self::$size);

        // TODO ...

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function mobility_e4()
    {
        $archbishop = new A('w', 'e4', self::$size);

        // TODO ...

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function mobility_d4()
    {
        $archbishop = new A('w', 'd4', self::$size);

        // TODO ...

        $this->assertTrue(true);
    }
}
