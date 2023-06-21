<?php

namespace Chess\Tests\Unit\Movetext;

use Chess\Movetext\RAV;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\PGN\Move;

class RavTest extends AbstractUnitTestCase
{
    static private $move;

    public static function setUpBeforeClass(): void
    {
        self::$move = new Move();
    }

    /**
     * @test
     */
    public function foo()
    {
        $this->expectException(\Chess\Exception\UnknownNotationException::class);

        (new RAV(self::$move, 'foo'))->validate();
    }
}
