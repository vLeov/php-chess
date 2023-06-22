<?php

namespace Chess\Tests\Unit\Play;

use Chess\Play\RAV;
use Chess\Tests\AbstractUnitTestCase;

class RavTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4_e5()
    {
        $movetext = '1.e4 e5';
        $board = (new RAV($movetext))->play()->getBoard();

        $this->assertSame($movetext, $board->getMovetext());
    }
}
