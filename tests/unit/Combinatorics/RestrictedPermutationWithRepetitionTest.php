<?php

namespace Chess\Tests\Unit\Combinatorics;

use Chess\Combinatorics\RestrictedPermutationWithRepetition;
use Chess\Tests\AbstractUnitTestCase;

class RestrictedPermutationWithRepetitionTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function first()
    {
        $set = (new RestrictedPermutationWithRepetition())->get([8, 13, 21, 34], 8, 100);

        $expected = [ 34, 13, 13, 8, 8, 8, 8, 8 ];

        $this->assertEquals($expected, $set[0]);
    }

    /**
     * @test
     */
    public function fibonacci_3_5_8_13_21()
    {
        $set = (new RestrictedPermutationWithRepetition())->get([3, 5, 8, 13, 21], 9, 100);

        $expected = 56448;

        $this->assertEquals($expected, count($set));
    }

    /**
     * @test
     */
    public function fibonacci_8_13_21_34()
    {
        $set = (new RestrictedPermutationWithRepetition())->get([8, 13, 21, 34], 8, 100);

        $expected = 588;

        $this->assertEquals($expected, count($set));
    }
}
