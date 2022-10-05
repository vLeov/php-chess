<?php

namespace Chess\Tests\Unit\Variant\Capablanca100\FEN;

use Chess\Variant\Capablanca100\FEN\ShortStrToPgn;
use Chess\Tests\AbstractUnitTestCase;

class ShortStrToPgnTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4()
    {
        $pgn = (new ShortStrToPgn(
            'rnabqkbcnr/pppppppppp/10/10/10/10/10/10/PPPPPPPPPP/RNABQKBCNR w KQkq -',
            'rnabqkbcnr/pppppppppp/10/10/10/10/4P5/10/PPPP1PPPPP/RNABQKBCNR b'
        ))->create();

        $expected = [
            'w' => 'e4',
        ];

        $this->assertSame($expected, $pgn);
    }
}
