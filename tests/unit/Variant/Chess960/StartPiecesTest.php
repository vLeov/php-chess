<?php

namespace Chess\Tests\Unit\Variant\Chess960;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Chess960\StartPieces;
use Chess\Variant\Chess960\StartPosition;
use Chess\Variant\Chess960\Rule\CastlingRule;

class StartPiecesTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function create()
    {
        $startPos = (new StartPosition())->create();
        $castlingRule =  (new CastlingRule($startPos))->getRule();

        $pieces = (new StartPieces($startPos, $castlingRule))->create();

        $this->assertSame(32, count($pieces));
    }
}
