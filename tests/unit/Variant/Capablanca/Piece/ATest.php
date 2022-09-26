<?php

namespace Chess\Tests\Unit\Variant\Capablanca\Piece;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca\Piece\A;

class ATest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function mobility_a1()
    {
        $archbishop = new A('w', 'a1');

        // TODO ...

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function mobility_e4()
    {
        $archbishop = new A('w', 'e4');

        // TODO ...

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function mobility_d4()
    {
        $archbishop = new A('w', 'd4');

        // TODO ...

        $this->assertTrue(true);
    }
}
