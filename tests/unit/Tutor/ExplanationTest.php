<?php

namespace Chess\Tests\Unit\Tutor;

use Chess\Tutor\Explanation;
use Chess\Tests\AbstractUnitTestCase;

class ExplanationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function deterministic_whites_knight()
    {
        $expected = "White's knight";

        $explanation = Explanation::deterministic('N');

        $this->assertSame($expected, $explanation);
    }

    /**
     * @test
     */
    public function deterministic_black_knight()
    {
        $expected = "Black's knight";

        $explanation = Explanation::deterministic('n');

        $this->assertSame($expected, $explanation);
    }
}
