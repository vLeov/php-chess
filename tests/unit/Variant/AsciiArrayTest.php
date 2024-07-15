<?php

namespace Chess\Tests\Unit\Variant;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\AsciiArray;

class AsciiArrayTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function from_index_to_algebraic_0_0()
    {
        $this->assertSame('a1', AsciiArray::toAlgebraic(0, 0));
    }

    /**
     * @test
     */
    public function from_index_to_algebraic_0_7()
    {
        $this->assertSame('a8', AsciiArray::toAlgebraic(0, 7));
    }

    /**
     * @test
     */
    public function from_index_to_algebraic_0_8()
    {
        $this->assertSame('a9', AsciiArray::toAlgebraic(0, 8));
    }
}
