<?php

namespace Chess\Tests\Unit\Tutor;

use Chess\Tutor\FenSentence;
use Chess\Tests\AbstractUnitTestCase;

class FenSentenceTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function endgame()
    {
        $expected = [
            "Black's knight on e6 is pinned.",
            "White has the bishop pair.",
        ];

        $sentence = (new FenSentence('8/5k2/4n3/8/8/1BK5/1B6/8 w - - 0 1'))
            ->getSentence();

        $this->assertSame($expected, $sentence);
    }
}
