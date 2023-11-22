<?php

namespace Chess\Tests\Unit\Variant\Classical\PGN\AN;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\Classical\PGN\AN\Square;
use Chess\Tests\AbstractUnitTestCase;

class SquareTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function integer_throws_exception()
    {
        $this->expectException(UnknownNotationException::class);

        Square::validate(9);
    }

    /**
     * @test
     */
    public function float_throws_exception()
    {
        $this->expectException(UnknownNotationException::class);

        Square::validate(9.75);
    }

    /**
     * @test
     */
    public function a9_throws_exception()
    {
        $this->expectException(UnknownNotationException::class);

        Square::validate('a9');
    }

    /**
     * @test
     */
    public function foo_throws_exception()
    {
        $this->expectException(UnknownNotationException::class);

        Square::validate('foo');
    }

    /**
     * @test
     */
    public function e4()
    {
        $this->assertSame(Square::validate('e4'), 'e4');
    }

    /**
     * @test
     */
    public function color_a1()
    {
        $this->assertSame(Square::color('a1'), 'b');
    }

    /**
     * @test
     */
    public function color_a2()
    {
        $this->assertSame(Square::color('a2'), 'w');
    }

    /**
     * @test
     */
    public function color_b1()
    {
        $this->assertSame(Square::color('b1'), 'w');
    }

    /**
     * @test
     */
    public function color_b2()
    {
        $this->assertSame(Square::color('b2'), 'b');
    }
}
