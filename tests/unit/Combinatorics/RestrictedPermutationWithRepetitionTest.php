<?php

namespace Chess\Tests\Unit\Combinatorics;

use Chess\Combinatorics\RestrictedPermutationWithRepetition;
use Chess\Tests\AbstractUnitTestCase;

class RestrictedPermutationWithRepetitionTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function fibonacci_100()
    {
        $set = (new RestrictedPermutationWithRepetition())->get([3, 5, 8, 13, 21], 9, 100);

        $expected = 56448;

        $this->assertEquals($expected, count($set));
    }
}
