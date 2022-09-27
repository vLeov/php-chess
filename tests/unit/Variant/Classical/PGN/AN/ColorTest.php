<?php

namespace Chess\Tests\Unit\Variant\Classical\PGN\AN;

use Chess\Variant\Classical\PGN\AN\Color;
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
    public function validate_w()
    {
        $this->assertSame(Color::W, Color::validate('w'));
    }

    /**
     * @test
     */
    public function validate_b()
    {
        $this->assertSame(Color::B, Color::validate('b'));
    }

    /**
     * @test
     */
    public function opp_w()
    {
        $this->assertSame(Color::B, Color::opp('w'));
    }

    /**
     * @test
     */
    public function values()
    {
        $expected = [
            'W' => 'w', 
            'B' => 'b',
        ];

        $this->assertSame($expected, Color::values());
    }
}
