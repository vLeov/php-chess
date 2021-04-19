<?php

namespace Chess\Tests\Unit\PGN\Validate;

use Chess\PGN\Symbol;
use Chess\PGN\Validate;
use Chess\Tests\AbstractUnitTestCase;

class SquareTest extends AbstractUnitTestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function integer_throws_exception()
    {
        Validate::square(9);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function float_throws_exception()
    {
        Validate::square(9.75);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function a9_throws_exception()
    {
        Validate::square('a9');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function foo_throws_exception()
    {
        Validate::square('foo');
    }

    /**
     * @test
     */
    public function e4()
    {
        $this->assertEquals(Validate::square('e4'), 'e4');
    }
}
