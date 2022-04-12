<?php

namespace Chess\Tests\Unit\PGN\SAN;

use Chess\PGN\SAN\Color;
use Chess\Tests\AbstractUnitTestCase;

class ColorTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function green_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        Color::validate('green');
    }

    /**
     * @test
     */
    public function white()
    {
        $this->assertSame(Color::W, Color::validate('w'));
    }

    /**
     * @test
     */
    public function black()
    {
        $this->assertSame(Color::B, Color::validate('b'));
    }
}
