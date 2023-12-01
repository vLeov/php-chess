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
    public function deterministic_whites_knight()
    {
        $expected = "White's knight on d4";

        $piece = new N('w', 'd4', self::$size);

        $explanation = PiecePhrase::deterministic($piece);

        $this->assertSame($expected, $explanation);
    }

    /**
     * @test
     */
    public function deterministic_black_knight()
    {
        $expected = "Black's knight on e4";

        $piece = new N('b', 'e4', self::$size);

        $explanation = PiecePhrase::deterministic($piece);

        $this->assertSame($expected, $explanation);
    }
}
