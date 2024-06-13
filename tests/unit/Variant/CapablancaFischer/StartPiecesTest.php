<?php

namespace Chess\Tests\Unit\Variant\CapablancaFischer;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\CapablancaFischer\StartPieces;
use Chess\Variant\CapablancaFischer\StartPosition;

class StartPiecesTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function create()
    {
        $startPos = (new StartPosition())->create();
        $pieces = (new StartPieces($startPos))->create();

        $this->assertSame(40, count($pieces));
    }
}
