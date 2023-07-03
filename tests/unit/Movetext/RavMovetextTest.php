<?php

namespace Chess\Tests\Unit\Movetext;

use Chess\Movetext\RavMovetext;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\PGN\Move;

class RavMovetextTest extends AbstractUnitTestCase
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

        (new RavMovetext(self::$move, 'foo'))->validate();
    }

    /**
     * @test
     */
    public function filtered_e4_e5__h5()
    {
        $movetext = '1. e4 e5 2. Nf3 Nc6 3. Bb5 Nf6 4. Nc3 Be7 5. d3 d6 6. Be3 Bd7 7. Qd2 a6 8. Ba4 b5 9. Bb3 O-O 10. O-O-O b4 11. Nd5 (11. Nb1 h6 12. h4 (12. Nh4 g5 13. Nf5) 12... a5 13. g4 Nxg4) 11... Nxd5 12. Bxd5 Rb8 13. h4 h6 14. Rdg1 a5 15. g4 g5 16. h5 (16. hxg5 Bxg5 17. Nxg5 hxg5 18. Rh5)';

        $expected = '1.e4 e5 2.Nf3 Nc6 3.Bb5 Nf6 4.Nc3 Be7 5.d3 d6 6.Be3 Bd7 7.Qd2 a6 8.Ba4 b5 9.Bb3 O-O 10.O-O-O b4 11.Nd5 (11.Nb1 h6 12.h4 (12.Nh4 g5 13.Nf5) 12...a5 13.g4 Nxg4) 11...Nxd5 12.Bxd5 Rb8 13.h4 h6 14.Rdg1 a5 15.g4 g5 16.h5 (16.hxg5 Bxg5 17.Nxg5 hxg5 18.Rh5)';

        $this->assertSame($expected, (new RavMovetext(self::$move, $movetext))->filtered());
    }

    /**
     * @test
     */
    public function main_e4_e5__h5()
    {
        $movetext = '1. e4 e5 2. Nf3 Nc6 3. Bb5 Nf6 4. Nc3 Be7 5. d3 d6 6. Be3 Bd7 7. Qd2 a6 8. Ba4 b5 9. Bb3 O-O 10. O-O-O b4 11. Nd5 (11. Nb1 h6 12. h4 (12. Nh4 g5 13. Nf5) 12... a5 13. g4 Nxg4) 11... Nxd5 12. Bxd5 Rb8 13. h4 h6 14. Rdg1 a5 15. g4 g5 16. h5 (16. hxg5 Bxg5 17. Nxg5 hxg5 18. Rh5)';

        $expected = '1.e4 e5 2.Nf3 Nc6 3.Bb5 Nf6 4.Nc3 Be7 5.d3 d6 6.Be3 Bd7 7.Qd2 a6 8.Ba4 b5 9.Bb3 O-O 10.O-O-O b4 11.Nd5 Nxd5 12.Bxd5 Rb8 13.h4 h6 14.Rdg1 a5 15.g4 g5 16.h5';

        $this->assertSame($expected, (new RavMovetext(self::$move, $movetext))->main());
    }

    /**
     * @test
     */
    public function main_Ra7_Kg8__Rc8()
    {
        $movetext = '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8 (5...Ke8 6.Kd6 Kf8 7.Ke6 Kg8 8.Kf6 Kh8 9.Kg6 Kg8 10.Ra8#) 6.Kd6 (6.Kc6 Kd8) 6...Kb8 (6...Kd8 7.Ra8#) 7.Rc7 Ka8 8.Kc6 Kb8 9.Kb6 Ka8 10.Rc8#';

        $expected = '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8 6.Kd6 Kb8 7.Rc7 Ka8 8.Kc6 Kb8 9.Kb6 Ka8 10.Rc8#';

        $this->assertSame($expected, (new RavMovetext(self::$move, $movetext))->main());
    }

    /**
     * @test
     */
    public function main_Ke2_Kd5__Kc1_Ra1()
    {
        $movetext = '1.Ke2 Kd5 2.Ke3 Kc4 (2...Ke5 3.Rh5+) (2...Kc4 3.Rh5) 3.Rh5 (3...Kb4 4.Kd3) 3...Kc3 4.Rh4 Kc2 5.Rc4+ Kb3 6.Kd3 Kb2 7.Rb4+ Ka3 8.Kc3 Ka2 9.Ra4+ Kb1 10.Ra5 Kc1 11.Ra1#';

        $expected = '1.Ke2 Kd5 2.Ke3 Kc4 3.Rh5 Kc3 4.Rh4 Kc2 5.Rc4+ Kb3 6.Kd3 Kb2 7.Rb4+ Ka3 8.Kc3 Ka2 9.Ra4+ Kb1 10.Ra5 Kc1 11.Ra1#';

        $this->assertSame($expected, (new RavMovetext(self::$move, $movetext))->main());
    }

    /**
     * @test
     */
    public function filtered_Ra7_Kg8__Rc8()
    {
        $movetext = '1.  Ke2 Kd5 {this is foo} 2.Ke3   Kc4 (2...Ke5 {this is bar} 3.Rh5+) (2...Kc4 3.Rh5) 3  .  Rh5 (3...Kb4 4.Kd3) {this is foobar} 3...Kc3 4.Rh4 Kc2 5.Rc4+ Kb3 6.Kd3 Kb2 7.Rb4+ Ka3 8.Kc3 Ka2 9.Ra4+ Kb1 10.Ra5 Kc1 11.Ra1#';

        $expected = '1.Ke2 Kd5 {this is foo} 2.Ke3 Kc4 (2...Ke5 {this is bar} 3.Rh5+) (2...Kc4 3.Rh5) 3.Rh5 (3...Kb4 4.Kd3) {this is foobar} 3...Kc3 4.Rh4 Kc2 5.Rc4+ Kb3 6.Kd3 Kb2 7.Rb4+ Ka3 8.Kc3 Ka2 9.Ra4+ Kb1 10.Ra5 Kc1 11.Ra1#';

        $this->assertSame($expected, (new RavMovetext(self::$move, $movetext))->filtered());
    }

    /**
     * @test
     */
    public function filtered_comments_Ra7_Kg8__Rc8()
    {
        $movetext = '1.  Ke2 Kd5 {this is foo} 2.Ke3   Kc4 (2...Ke5 {this is bar} 3.Rh5+) (2...Kc4 3.Rh5) 3  .  Rh5 (3...Kb4 4.Kd3) {this is foobar} 3...Kc3 4.Rh4 Kc2 5.Rc4+ Kb3 6.Kd3 Kb2 7.Rb4+ Ka3 8.Kc3 Ka2 9.Ra4+ Kb1 10.Ra5 Kc1 11.Ra1#';

        $expected = '1.Ke2 Kd5 2.Ke3 Kc4 (2...Ke5 3.Rh5+) (2...Kc4 3.Rh5) 3.Rh5 (3...Kb4 4.Kd3) 3...Kc3 4.Rh4 Kc2 5.Rc4+ Kb3 6.Kd3 Kb2 7.Rb4+ Ka3 8.Kc3 Ka2 9.Ra4+ Kb1 10.Ra5 Kc1 11.Ra1#';

        $this->assertSame($expected, (new RavMovetext(self::$move, $movetext))->filtered($comments = false));
    }

    /**
     * @test
     */
    public function sicilian_commented()
    {
        $movetext = '1.e4 c5 {foo} (2.Nf3 d6 {foobar}) (2.Nf3 Nc6)';

        $expected = '1.e4 c5 (2.Nf3 d6) (2.Nf3 Nc6)';

        $this->assertSame($expected, (new RavMovetext(self::$move, $movetext))->filtered($comments = false));
    }
}
