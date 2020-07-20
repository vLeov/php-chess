<?php

namespace PGNChess\Tests\Unit\PGN\Validate;

use PGNChess\PGN\Symbol;
use PGNChess\PGN\Validate;
use PGNChess\Tests\AbstractUnitTestCase;

class ColorTest extends AbstractUnitTestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function green_throws_exception()
    {
        Validate::color('green');
    }

    /**
     * @test
     */
    public function white()
    {
        $this->assertEquals(Symbol::WHITE, Validate::color(Symbol::WHITE));
    }

    /**
     * @test
     */
    public function black()
    {
        $this->assertEquals(Symbol::BLACK, Validate::color(Symbol::BLACK));
    }
}
