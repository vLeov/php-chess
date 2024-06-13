<?php

namespace Chess\Tests\Unit\Variant\Chess960;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Chess960\StartPieces;
use Chess\Variant\Chess960\StartPosition;

class StartPiecesTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function create()
    {
        $startPos = (new StartPosition())->create();
        $pieces = (new StartPieces($startPos))->create();

        $this->assertSame(32, count($pieces));
    }
}
