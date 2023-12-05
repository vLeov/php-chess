<?php

namespace Chess\Tests\Unit\Tutor;

use Chess\Piece\N;
use Chess\Tutor\PiecePhrase;
use Chess\Tests\AbstractUnitTestCase;

class PiecePhraseTest extends AbstractUnitTestCase
{
    static private $size;

    public static function setUpBeforeClass(): void
    {
        self::$size = [
            'files' => 8,
            'ranks' => 8,
        ];
    }

    /**
     * @test
     */
    public function predictable_whites_knight()
    {
        $expected = "the knight on d4";

        $piece = new N('w', 'd4', self::$size);

        $explanation = PiecePhrase::predictable($piece);

        $this->assertSame($expected, $explanation);
    }

    /**
     * @test
     */
    public function predictable_black_knight()
    {
        $expected = "the knight on e4";

        $piece = new N('b', 'e4', self::$size);

        $explanation = PiecePhrase::predictable($piece);

        $this->assertSame($expected, $explanation);
    }
}
