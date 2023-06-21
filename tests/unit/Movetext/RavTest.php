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

    /**
     * @test
     */
    public function e4_e5__h5()
    {
        $movetext = '1. e4 e5 2. Nf3 Nc6 3. Bb5 Nf6 4. Nc3 Be7 5. d3 d6 6. Be3 Bd7 7. Qd2 a6 8. Ba4 b5 9. Bb3 O-O 10. O-O-O b4 11. Nd5 (11. Nb1 h6 12. h4 (12. Nh4 g5 13. Nf5) 12... a5 13. g4 Nxg4) 11... Nxd5 12. Bxd5 Rb8 13. h4 h6 14. Rdg1 a5 15. g4 g5 16. h5 (16. hxg5 Bxg5 17. Nxg5 hxg5 18. Rh5)';

        $expected = '1.e4 e5 2.Nf3 Nc6 3.Bb5 Nf6 4.Nc3 Be7 5.d3 d6 6.Be3 Bd7 7.Qd2 a6 8.Ba4 b5 9.Bb3 O-O 10.O-O-O b4 11.Nd5 Nxd5 12.Bxd5 Rb8 13.h4 h6 14.Rdg1 a5 15.g4 g5 16.h5';

        $this->assertSame($expected, (new RAV(self::$move, $movetext))->validate());
    }
}
