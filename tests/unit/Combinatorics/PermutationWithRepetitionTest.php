<?php

namespace Chess\Tests\Unit\Combinatorics;

use Chess\Combinatorics\PermutationWithRepetition;
use Chess\Tests\AbstractUnitTestCase;

class PermutationWithRepetitionTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function a_b_c_2()
    {
        $set = (new PermutationWithRepetition())->get(['a', 'b', 'c'], 2);

        $expected = [
            ['a', 'a'],
            ['b', 'a'],
            ['c', 'a'],
            ['a', 'b'],
            ['b', 'b'],
            ['c', 'b'],
            ['a', 'c'],
            ['b', 'c'],
            ['c', 'c'],
        ];

        $this->assertSame($expected, $set);
    }
}
