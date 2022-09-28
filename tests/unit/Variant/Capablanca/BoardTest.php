<?php

namespace Chess\Tests\Unit\Variant\Capablanca;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca\Board;

class BoardTest extends AbstractUnitTestCase
{
    /*
    |--------------------------------------------------------------------------
    | getPieces()
    |--------------------------------------------------------------------------
    |
    | Gets all pieces.
    |
    */

    /**
     * @test
     */
    public function get_pieces()
    {
        $pieces = (new Board())->getPieces();

        $this->assertSame(40, count($pieces));
    }
}
