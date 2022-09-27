<?php

namespace Chess\Tests\Unit\Variant\Classical\FEN\Field;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\Classical\FEN\Field\EnPassantTargetSquare;
use Chess\Tests\AbstractUnitTestCase;

class EnPassantTargetSquareTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function integer_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        EnPassantTargetSquare::validate(9);
    }

    /**
     * @test
     */
    public function float_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        EnPassantTargetSquare::validate(9.75);
    }

    /**
     * @test
     */
    public function a9_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        EnPassantTargetSquare::validate('a9');
    }

    /**
     * @test
     */
    public function foo_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        EnPassantTargetSquare::validate('foo');
    }

    /**
     * @test
     */
    public function e4()
    {
        $this->assertSame(EnPassantTargetSquare::validate('e4'), 'e4');
    }
}
