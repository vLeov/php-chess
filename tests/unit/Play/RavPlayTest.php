<?php

namespace Chess\Tests\Unit\Play;

use Chess\Play\RavPlay;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\FEN\StrToBoard;

class RavPlayTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4_e5()
    {
        $movetext = '1.e4 e5';
        $board = (new RavPlay($movetext))->validate()->getBoard();

        $this->assertSame($movetext, $board->getMovetext());
    }

    /**
     * @test
     */
    public function breakdown_e4_e5__h5()
    {
        $movetext = '1. e4 e5 2. Nf3 Nc6 3. Bb5 Nf6 4. Nc3 Be7 5. d3 d6 6. Be3 Bd7 7. Qd2 a6 8. Ba4 b5 9. Bb3 O-O 10. O-O-O b4 11. Nd5
            (11. Nb1 h6 12. h4
            (12. Nh4 g5 13. Nf5)
            12... a5 13. g4 Nxg4)
            11... Nxd5 12. Bxd5 Rb8 13. h4 h6 14. Rdg1 a5 15. g4 g5 16. h5
            (16. hxg5 Bxg5 17. Nxg5 hxg5 18. Rh5)';

        $breakdown = (new RavPlay($movetext))->getBreakdown();

        $expected = [
            '1.e4 e5 2.Nf3 Nc6 3.Bb5 Nf6 4.Nc3 Be7 5.d3 d6 6.Be3 Bd7 7.Qd2 a6 8.Ba4 b5 9.Bb3 O-O 10.O-O-O b4 11.Nd5',
            '11.Nb1 h6 12.h4',
            '12.Nh4 g5 13.Nf5',
            '12...a5 13.g4 Nxg4',
            '11...Nxd5 12.Bxd5 Rb8 13.h4 h6 14.Rdg1 a5 15.g4 g5 16.h5',
            '16.hxg5 Bxg5 17.Nxg5 hxg5 18.Rh5',
        ];

        $this->assertSame($expected, (new RavPlay($movetext))->getBreakdown());
    }

    /**
     * @test
     */
    public function breakdown_starting_with_ellipsis_Nc6__h5()
    {
        $movetext = '2...Nc6 3. Bb5 Nf6 4. Nc3 Be7 5. d3 d6 6. Be3 Bd7 7. Qd2 a6 8. Ba4 b5 9. Bb3 O-O 10. O-O-O b4 11. Nd5
            (11. Nb1 h6 12. h4
            (12. Nh4 g5 13. Nf5)
            12... a5 13. g4 Nxg4)
            11... Nxd5 12. Bxd5 Rb8 13. h4 h6 14. Rdg1 a5 15. g4 g5 16. h5
            (16. hxg5 Bxg5 17. Nxg5 hxg5 18. Rh5)';

        $breakdown = (new RavPlay($movetext))->getBreakdown();

        $expected = [
            '2...Nc6 3.Bb5 Nf6 4.Nc3 Be7 5.d3 d6 6.Be3 Bd7 7.Qd2 a6 8.Ba4 b5 9.Bb3 O-O 10.O-O-O b4 11.Nd5',
            '11.Nb1 h6 12.h4',
            '12.Nh4 g5 13.Nf5',
            '12...a5 13.g4 Nxg4',
            '11...Nxd5 12.Bxd5 Rb8 13.h4 h6 14.Rdg1 a5 15.g4 g5 16.h5',
            '16.hxg5 Bxg5 17.Nxg5 hxg5 18.Rh5',
        ];

        $this->assertSame($expected, (new RavPlay($movetext))->getBreakdown());
    }

    /**
     * @test
     */
    public function breakdown_Ra7_Kg8__Rc8()
    {
        $movetext = '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8
            (5...Ke8 6.Kd6 Kf8 7.Ke6 Kg8 8.Kf6 Kh8 9.Kg6 Kg8 10.Ra8#)
            6.Kd6
            (6.Kc6 Kd8)
            6...Kb8
            (6...Kd8 7.Ra8#)
            7.Rc7 Ka8 8.Kc6 Kb8 9.Kb6 Ka8 10.Rc8#';

        $expected = [
            '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8',
            '5...Ke8 6.Kd6 Kf8 7.Ke6 Kg8 8.Kf6 Kh8 9.Kg6 Kg8 10.Ra8#',
            '6.Kd6',
            '6.Kc6 Kd8',
            '6...Kb8',
            '6...Kd8 7.Ra8#',
            '7.Rc7 Ka8 8.Kc6 Kb8 9.Kb6 Ka8 10.Rc8#',
        ];

        $this->assertSame($expected, (new RavPlay($movetext))->getBreakdown());
    }

    /**
     * @test
     */
    public function breakdown_Ke2_Kd5__Ra1()
    {
        $movetext = '1.Ke2 Kd5 2.Ke3 Kc4
            (2...Ke5 3.Rh5+)
            (2...Kc4 3.Rh5)
            3.Rh5
            (3...Kb4 4.Kd3)
            3...Kc3 4.Rh4 Kc2 5.Rc4+ Kb3 6.Kd3 Kb2 7.Rb4+ Ka3 8.Kc3 Ka2 9.Ra4+ Kb1 10.Ra5 Kc1 11.Ra1#';

        $expected = [
            '1.Ke2 Kd5 2.Ke3 Kc4',
            '2...Ke5 3.Rh5+',
            '2...Kc4 3.Rh5',
            '3.Rh5',
            '3...Kb4 4.Kd3',
            '3...Kc3 4.Rh4 Kc2 5.Rc4+ Kb3 6.Kd3 Kb2 7.Rb4+ Ka3 8.Kc3 Ka2 9.Ra4+ Kb1 10.Ra5 Kc1 11.Ra1#',
        ];

        $this->assertSame($expected, (new RavPlay($movetext))->getBreakdown());
    }

    /**
     * @test
     */
    public function breakdown_starting_with_ellipsis_Kc4__Ra1()
    {
        $movetext = '2...Kc4
            (2...Ke5 3.Rh5+)
            (2...Kc4 3.Rh5)
            3.Rh5
            (3...Kb4 4.Kd3)
            3...Kc3 4.Rh4 Kc2 5.Rc4+ Kb3 6.Kd3 Kb2 7.Rb4+ Ka3 8.Kc3 Ka2 9.Ra4+ Kb1 10.Ra5 Kc1 11.Ra1#';

        $expected = [
            '2...Kc4',
            '2...Ke5 3.Rh5+',
            '2...Kc4 3.Rh5',
            '3.Rh5',
            '3...Kb4 4.Kd3',
            '3...Kc3 4.Rh4 Kc2 5.Rc4+ Kb3 6.Kd3 Kb2 7.Rb4+ Ka3 8.Kc3 Ka2 9.Ra4+ Kb1 10.Ra5 Kc1 11.Ra1#',
        ];

        $this->assertSame($expected, (new RavPlay($movetext))->getBreakdown());
    }

    /**
     * @test
     */
    public function play_e4_e5__h5()
    {
        $movetext = '1. e4 e5 2. Nf3 Nc6 3. Bb5 Nf6 4. Nc3 Be7 5. d3 d6 6. Be3 Bd7 7. Qd2 a6 8. Ba4 b5 9. Bb3 O-O 10. O-O-O b4 11. Nd5
            (11. Nb1 h6 12. h4
            (12. Nh4 g5 13. Nf5)
            12... a5 13. g4 Nxg4)
            11... Nxd5 12. Bxd5 Rb8 13. h4 h6 14. Rdg1 a5 15. g4 g5 16. h5
            (16. hxg5 Bxg5 17. Nxg5 hxg5 18. Rh5)';

        $board = (new RavPlay($movetext))->validate()->getBoard();

        $expected = '1.e4 e5 2.Nf3 Nc6 3.Bb5 Nf6 4.Nc3 Be7 5.d3 d6 6.Be3 Bd7 7.Qd2 a6 8.Ba4 b5 9.Bb3 O-O 10.O-O-O b4 11.Nd5 Nxd5 12.Bxd5 Rb8 13.h4 h6 14.Rdg1 a5 15.g4 g5 16.h5';

        $this->assertSame($expected, $board->getMovetext());
    }

    /**
     * @test
     */
    public function fen_e4_e5__h5()
    {
        $movetext = '1. e4 e5 2. Nf3 Nc6 3. Bb5 Nf6 4. Nc3 Be7 5. d3 d6 6. Be3 Bd7 7. Qd2 a6 8. Ba4 b5 9. Bb3 O-O 10. O-O-O b4 11. Nd5
            (11. Nb1 h6 12. h4
            (12. Nh4 g5 13. Nf5)
            12... a5 13. g4 Nxg4)
            11... Nxd5 12. Bxd5 Rb8 13. h4 h6 14. Rdg1 a5 15. g4 g5 16. h5
            (16. hxg5 Bxg5 17. Nxg5 hxg5 18. Rh5)';

        $expected = [
            'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq -',
            'rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3',
            'rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq e6',
            'rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b KQkq -',
            'r1bqkbnr/pppp1ppp/2n5/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R w KQkq -',
            'r1bqkbnr/pppp1ppp/2n5/1B2p3/4P3/5N2/PPPP1PPP/RNBQK2R b KQkq -',
            'r1bqkb1r/pppp1ppp/2n2n2/1B2p3/4P3/5N2/PPPP1PPP/RNBQK2R w KQkq -',
            'r1bqkb1r/pppp1ppp/2n2n2/1B2p3/4P3/2N2N2/PPPP1PPP/R1BQK2R b KQkq -',
            'r1bqk2r/ppppbppp/2n2n2/1B2p3/4P3/2N2N2/PPPP1PPP/R1BQK2R w KQkq -',
            'r1bqk2r/ppppbppp/2n2n2/1B2p3/4P3/2NP1N2/PPP2PPP/R1BQK2R b KQkq -',
            'r1bqk2r/ppp1bppp/2np1n2/1B2p3/4P3/2NP1N2/PPP2PPP/R1BQK2R w KQkq -',
            'r1bqk2r/ppp1bppp/2np1n2/1B2p3/4P3/2NPBN2/PPP2PPP/R2QK2R b KQkq -',
            'r2qk2r/pppbbppp/2np1n2/1B2p3/4P3/2NPBN2/PPP2PPP/R2QK2R w KQkq -',
            'r2qk2r/pppbbppp/2np1n2/1B2p3/4P3/2NPBN2/PPPQ1PPP/R3K2R b KQkq -',
            'r2qk2r/1ppbbppp/p1np1n2/1B2p3/4P3/2NPBN2/PPPQ1PPP/R3K2R w KQkq -',
            'r2qk2r/1ppbbppp/p1np1n2/4p3/B3P3/2NPBN2/PPPQ1PPP/R3K2R b KQkq -',
            'r2qk2r/2pbbppp/p1np1n2/1p2p3/B3P3/2NPBN2/PPPQ1PPP/R3K2R w KQkq b6',
            'r2qk2r/2pbbppp/p1np1n2/1p2p3/4P3/1BNPBN2/PPPQ1PPP/R3K2R b KQkq -',
            'r2q1rk1/2pbbppp/p1np1n2/1p2p3/4P3/1BNPBN2/PPPQ1PPP/R3K2R w KQ -',
            'r2q1rk1/2pbbppp/p1np1n2/1p2p3/4P3/1BNPBN2/PPPQ1PPP/2KR3R b - -',
            'r2q1rk1/2pbbppp/p1np1n2/4p3/1p2P3/1BNPBN2/PPPQ1PPP/2KR3R w - -',
            'r2q1rk1/2pbbppp/p1np1n2/3Np3/1p2P3/1B1PBN2/PPPQ1PPP/2KR3R b - -',
            'r2q1rk1/2pbbppp/p1np1n2/4p3/1p2P3/1B1PBN2/PPPQ1PPP/1NKR3R b - -',
            'r2q1rk1/2pbbpp1/p1np1n1p/4p3/1p2P3/1B1PBN2/PPPQ1PPP/1NKR3R w - -',
            'r2q1rk1/2pbbpp1/p1np1n1p/4p3/1p2P2P/1B1PBN2/PPPQ1PP1/1NKR3R b - h3',
            'r2q1rk1/2pbbpp1/p1np1n1p/4p3/1p2P2N/1B1PB3/PPPQ1PPP/1NKR3R b - -',
            'r2q1rk1/2pbbp2/p1np1n1p/4p1p1/1p2P2N/1B1PB3/PPPQ1PPP/1NKR3R w - g6',
            'r2q1rk1/2pbbp2/p1np1n1p/4pNp1/1p2P3/1B1PB3/PPPQ1PPP/1NKR3R b - -',
            'r2q1rk1/2pbbpp1/2np1n1p/p3p3/1p2P2P/1B1PBN2/PPPQ1PP1/1NKR3R w - -',
            'r2q1rk1/2pbbpp1/2np1n1p/p3p3/1p2P1PP/1B1PBN2/PPPQ1P2/1NKR3R b - g3',
            'r2q1rk1/2pbbpp1/2np3p/p3p3/1p2P1nP/1B1PBN2/PPPQ1P2/1NKR3R w - -',
            'r2q1rk1/2pbbppp/p1np4/3np3/1p2P3/1B1PBN2/PPPQ1PPP/2KR3R w - -',
            'r2q1rk1/2pbbppp/p1np4/3Bp3/1p2P3/3PBN2/PPPQ1PPP/2KR3R b - -',
            '1r1q1rk1/2pbbppp/p1np4/3Bp3/1p2P3/3PBN2/PPPQ1PPP/2KR3R w - -',
            '1r1q1rk1/2pbbppp/p1np4/3Bp3/1p2P2P/3PBN2/PPPQ1PP1/2KR3R b - h3',
            '1r1q1rk1/2pbbpp1/p1np3p/3Bp3/1p2P2P/3PBN2/PPPQ1PP1/2KR3R w - -',
            '1r1q1rk1/2pbbpp1/p1np3p/3Bp3/1p2P2P/3PBN2/PPPQ1PP1/2K3RR b - -',
            '1r1q1rk1/2pbbpp1/2np3p/p2Bp3/1p2P2P/3PBN2/PPPQ1PP1/2K3RR w - -',
            '1r1q1rk1/2pbbpp1/2np3p/p2Bp3/1p2P1PP/3PBN2/PPPQ1P2/2K3RR b - g3',
            '1r1q1rk1/2pbbp2/2np3p/p2Bp1p1/1p2P1PP/3PBN2/PPPQ1P2/2K3RR w - g6',
            '1r1q1rk1/2pbbp2/2np3p/p2Bp1pP/1p2P1P1/3PBN2/PPPQ1P2/2K3RR b - -',
            '1r1q1rk1/2pbbp2/2np3p/p2Bp1P1/1p2P1P1/3PBN2/PPPQ1P2/2K3RR b - -',
            '1r1q1rk1/2pb1p2/2np3p/p2Bp1b1/1p2P1P1/3PBN2/PPPQ1P2/2K3RR w - -',
            '1r1q1rk1/2pb1p2/2np3p/p2Bp1N1/1p2P1P1/3PB3/PPPQ1P2/2K3RR b - -',
            '1r1q1rk1/2pb1p2/2np4/p2Bp1p1/1p2P1P1/3PB3/PPPQ1P2/2K3RR w - -',
            '1r1q1rk1/2pb1p2/2np4/p2Bp1pR/1p2P1P1/3PB3/PPPQ1P2/2K3R1 b - -',
        ];

        $this->assertSame($expected, (new RavPlay($movetext))->fen()->getFen());
    }

    /**
     * @test
     */
    public function filtered_e4_e5__h5()
    {
        $movetext = '1. e4 e5 {foo} 2. Nf3 {bar} Nc6 3. Bb5 Nf6 4. Nc3 Be7 5. d3 d6 6. Be3 Bd7 7. Qd2 a6 8. Ba4 b5 9. Bb3 O-O 10. O-O-O b4 11. Nd5 {foobar}
            (11. Nb1 h6 12. h4
            (12. Nh4 g5 13. Nf5)
            12... a5 13. g4 Nxg4)
            11... Nxd5 12. Bxd5 Rb8 13. h4 h6 14. Rdg1 a5 15. g4 g5 16. h5
            (16. hxg5 Bxg5 17. Nxg5 hxg5 18. Rh5)';

        $expected = '1.e4 e5 {foo} 2.Nf3 {bar} Nc6 3.Bb5 Nf6 4.Nc3 Be7 5.d3 d6 6.Be3 Bd7 7.Qd2 a6 8.Ba4 b5 9.Bb3 O-O 10.O-O-O b4 11.Nd5 {foobar} (11.Nb1 h6 12.h4 (12.Nh4 g5 13.Nf5) 12...a5 13.g4 Nxg4) 11...Nxd5 12.Bxd5 Rb8 13.h4 h6 14.Rdg1 a5 15.g4 g5 16.h5 (16.hxg5 Bxg5 17.Nxg5 hxg5 18.Rh5)';

        $this->assertSame($expected, (new RavPlay($movetext))->getRavMovetext()->filtered());
    }

    /**
     * @test
     */
    public function filtered_d4_d5__Nxb5_Ng4()
    {
        $movetext = '1.d4 d5 2.c4 c6 3.Nc3 Nf6 4.e3 e6 5.Nf3 Nbd7 6.Bd3 dxc4 7.Bxc4 b5 8.Bd3 a6 9.e4 c5 10.e5 cxd4 11.Nxb5 Ng4';

        $expected = '1.d4 d5 2.c4 c6 3.Nc3 Nf6 4.e3 e6 5.Nf3 Nbd7 6.Bd3 dxc4 7.Bxc4 b5 8.Bd3 a6 9.e4 c5 10.e5 cxd4 11.Nxb5 Ng4';

        $this->assertSame($expected, (new RavPlay($movetext))->getRavMovetext()->filtered());
    }

    /**
     * @test
     */
    public function validate_d4_d5__Nxb5_Ng4()
    {
        $movetext = '1.d4 d5 2.c4 c6 3.Nc3 Nf6 4.e3 e6 5.Nf3 Nbd7 6.Bd3 dxc4 7.Bxc4 b5 8.Bd3 a6 9.e4 c5 10.e5 cxd4 11.Nxb5 Ng4';

        $expected = '1.d4 d5 2.c4 c6 3.Nc3 Nf6 4.e3 e6 5.Nf3 Nbd7 6.Bd3 dxc4 7.Bxc4 b5 8.Bd3 a6 9.e4 c5 10.e5 cxd4 11.Nxb5 Ng4';

        $this->assertSame($expected, (new RavPlay($movetext))->getRavMovetext()->validate());
    }

    /**
     * @test
     */
    public function fen_d4_d5__Nxb5_Ng4()
    {
        $movetext = '1.d4 d5 2.c4 c6 3.Nc3 Nf6 4.e3 e6 5.Nf3 Nbd7';

        $expected = [
            'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq -',
            'rnbqkbnr/pppppppp/8/8/3P4/8/PPP1PPPP/RNBQKBNR b KQkq d3',
            'rnbqkbnr/ppp1pppp/8/3p4/3P4/8/PPP1PPPP/RNBQKBNR w KQkq d6',
            'rnbqkbnr/ppp1pppp/8/3p4/2PP4/8/PP2PPPP/RNBQKBNR b KQkq c3',
            'rnbqkbnr/pp2pppp/2p5/3p4/2PP4/8/PP2PPPP/RNBQKBNR w KQkq -',
            'rnbqkbnr/pp2pppp/2p5/3p4/2PP4/2N5/PP2PPPP/R1BQKBNR b KQkq -',
            'rnbqkb1r/pp2pppp/2p2n2/3p4/2PP4/2N5/PP2PPPP/R1BQKBNR w KQkq -',
            'rnbqkb1r/pp2pppp/2p2n2/3p4/2PP4/2N1P3/PP3PPP/R1BQKBNR b KQkq -',
            'rnbqkb1r/pp3ppp/2p1pn2/3p4/2PP4/2N1P3/PP3PPP/R1BQKBNR w KQkq -',
            'rnbqkb1r/pp3ppp/2p1pn2/3p4/2PP4/2N1PN2/PP3PPP/R1BQKB1R b KQkq -',
            'r1bqkb1r/pp1n1ppp/2p1pn2/3p4/2PP4/2N1PN2/PP3PPP/R1BQKB1R w KQkq -',
        ];

        $this->assertSame($expected, (new RavPlay($movetext))->fen()->getFen());
    }

    /**
     * @test
     */
    public function play_and_fen_d4_d5__Nxb5_Ng4()
    {
        $movetext = '1.d4 d5 2.c4 c6 3.Nc3 Nf6 4.e3 e6 5.Nf3 Nbd7';

        $ravPlay = new RavPlay($movetext);
        $board = $ravPlay->validate()->getBoard();
        $fen = $ravPlay->fen()->getFen();

        $expectedMovetext = '1.d4 d5 2.c4 c6 3.Nc3 Nf6 4.e3 e6 5.Nf3 Nbd7';

        $expectedFen = [
            'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq -',
            'rnbqkbnr/pppppppp/8/8/3P4/8/PPP1PPPP/RNBQKBNR b KQkq d3',
            'rnbqkbnr/ppp1pppp/8/3p4/3P4/8/PPP1PPPP/RNBQKBNR w KQkq d6',
            'rnbqkbnr/ppp1pppp/8/3p4/2PP4/8/PP2PPPP/RNBQKBNR b KQkq c3',
            'rnbqkbnr/pp2pppp/2p5/3p4/2PP4/8/PP2PPPP/RNBQKBNR w KQkq -',
            'rnbqkbnr/pp2pppp/2p5/3p4/2PP4/2N5/PP2PPPP/R1BQKBNR b KQkq -',
            'rnbqkb1r/pp2pppp/2p2n2/3p4/2PP4/2N5/PP2PPPP/R1BQKBNR w KQkq -',
            'rnbqkb1r/pp2pppp/2p2n2/3p4/2PP4/2N1P3/PP3PPP/R1BQKBNR b KQkq -',
            'rnbqkb1r/pp3ppp/2p1pn2/3p4/2PP4/2N1P3/PP3PPP/R1BQKBNR w KQkq -',
            'rnbqkb1r/pp3ppp/2p1pn2/3p4/2PP4/2N1PN2/PP3PPP/R1BQKB1R b KQkq -',
            'r1bqkb1r/pp1n1ppp/2p1pn2/3p4/2PP4/2N1PN2/PP3PPP/R1BQKB1R w KQkq -',
        ];

        $this->assertSame($expectedMovetext, $board->getMovetext());
        $this->assertSame($expectedFen, $fen);
    }

    /**
     * @test
     */
    public function play_d4_d5__Nxb5_Ng4()
    {
        $movetext = '1. e4 e5 {foo} 2. Nf3 {bar} Nc6 3. Bb5 Nf6 4. Nc3 Be7 5. d3 d6 6. Be3 Bd7 7. Qd2 a6 8. Ba4 b5 9. Bb3 O-O 10. O-O-O b4 11. Nd5 {foobar}
            (11. Nb1 h6 12. h4
            (12. Nh4 g5 13. Nf5)
            12... a5 13. g4 Nxg4)
            11... Nxd5 12. Bxd5 Rb8 13. h4 h6 14. Rdg1 a5 15. g4 g5 16. h5
            (16. hxg5 Bxg5 17. Nxg5 hxg5 18. Rh5)';

        $ravPlay = new RavPlay($movetext);
        $board = $ravPlay->validate()->getBoard();

        $expectedMovetext = '1.e4 e5 2.Nf3 Nc6 3.Bb5 Nf6 4.Nc3 Be7 5.d3 d6 6.Be3 Bd7 7.Qd2 a6 8.Ba4 b5 9.Bb3 O-O 10.O-O-O b4 11.Nd5 Nxd5 12.Bxd5 Rb8 13.h4 h6 14.Rdg1 a5 15.g4 g5 16.h5';

        $this->assertSame($expectedMovetext, $board->getMovetext());
    }

    /**
     * @test
     */
    public function breakdown_chess_fundamentals()
    {
        $fen = '7k/8/8/8/8/8/8/R6K w - -';

        $movetext = '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8
            (5...Ke8 6.Kd6 Kf8 7.Ke6 Kg8 8.Kf6 Kh8 9.Kg6 Kg8 10.Ra8#)
            6.Kd6
            (6.Kc6 Kd8)
            6...Kb8
            (6...Kd8 7.Ra8#)';

        $board = (new StrToBoard($fen))->create();

        $ravPlay = new RavPlay($movetext, $board);

        $breakdown = $ravPlay->getBreakdown();

        $expected = [
            '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8',
            '5...Ke8 6.Kd6 Kf8 7.Ke6 Kg8 8.Kf6 Kh8 9.Kg6 Kg8 10.Ra8#',
            '6.Kd6',
            '6.Kc6 Kd8',
            '6...Kb8',
            '6...Kd8 7.Ra8#',
        ];

        $this->assertSame($expected, $breakdown);
    }

    /**
     * @test
     */
    public function fen_chess_fundamentals_Ra7_Kg8__Kd5_Kc8()
    {
        $fen = '7k/8/8/8/8/8/8/R6K w - -';

        $movetext = '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8';

        $board = (new StrToBoard($fen))->create();

        $fen = (new RavPlay($movetext, $board))->fen()->getFen();

        $expected = [
            '7k/8/8/8/8/8/8/R6K w - -',
            '7k/R7/8/8/8/8/8/7K b - -',
            '6k1/R7/8/8/8/8/8/7K w - -',
            '6k1/R7/8/8/8/8/6K1/8 b - -',
            '5k2/R7/8/8/8/8/6K1/8 w - -',
            '5k2/R7/8/8/8/5K2/8/8 b - -',
            '4k3/R7/8/8/8/5K2/8/8 w - -',
            '4k3/R7/8/8/4K3/8/8/8 b - -',
            '3k4/R7/8/8/4K3/8/8/8 w - -',
            '3k4/R7/8/3K4/8/8/8/8 b - -',
            '2k5/R7/8/3K4/8/8/8/8 w - -',
        ];

        $this->assertSame($expected, $fen);
    }

    /**
     * @test
     */
    public function fen_chess_fundamentals_Ra7_Kg8__Ra8()
    {
        $fen = '7k/8/8/8/8/8/8/R6K w - -';

        $movetext = '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8
            (5...Ke8 6.Kd6 Kf8 7.Ke6 Kg8 8.Kf6 Kh8 9.Kg6 Kg8 10.Ra8#)';

        $board = (new StrToBoard($fen))->create();

        $fen = (new RavPlay($movetext, $board))->fen()->getFen();

        $expected = [
            '7k/8/8/8/8/8/8/R6K w - -',
            '7k/R7/8/8/8/8/8/7K b - -',
            '6k1/R7/8/8/8/8/8/7K w - -',
            '6k1/R7/8/8/8/8/6K1/8 b - -',
            '5k2/R7/8/8/8/8/6K1/8 w - -',
            '5k2/R7/8/8/8/5K2/8/8 b - -',
            '4k3/R7/8/8/8/5K2/8/8 w - -',
            '4k3/R7/8/8/4K3/8/8/8 b - -',
            '3k4/R7/8/8/4K3/8/8/8 w - -',
            '3k4/R7/8/3K4/8/8/8/8 b - -',
            '2k5/R7/8/3K4/8/8/8/8 w - -',
            '4k3/R7/8/3K4/8/8/8/8 w - -',
            '4k3/R7/3K4/8/8/8/8/8 b - -',
            '5k2/R7/3K4/8/8/8/8/8 w - -',
            '5k2/R7/4K3/8/8/8/8/8 b - -',
            '6k1/R7/4K3/8/8/8/8/8 w - -',
            '6k1/R7/5K2/8/8/8/8/8 b - -',
            '7k/R7/5K2/8/8/8/8/8 w - -',
            '7k/R7/6K1/8/8/8/8/8 b - -',
            '6k1/R7/6K1/8/8/8/8/8 w - -',
            'R5k1/8/6K1/8/8/8/8/8 b - -',
        ];

        $this->assertSame($expected, $fen);
    }

    /**
     * @test
     */
    public function fen_chess_fundamentals_Ra7_Kg8__Kd6()
    {
        $fen = '7k/8/8/8/8/8/8/R6K w - -';

        $movetext = '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8
            (5...Ke8 6.Kd6 Kf8 7.Ke6 Kg8 8.Kf6 Kh8 9.Kg6 Kg8 10.Ra8#)
            6.Kd6';

        $board = (new StrToBoard($fen))->create();

        $fen = (new RavPlay($movetext, $board))->fen()->getFen();

        $expected = [
            '7k/8/8/8/8/8/8/R6K w - -',
            '7k/R7/8/8/8/8/8/7K b - -',
            '6k1/R7/8/8/8/8/8/7K w - -',
            '6k1/R7/8/8/8/8/6K1/8 b - -',
            '5k2/R7/8/8/8/8/6K1/8 w - -',
            '5k2/R7/8/8/8/5K2/8/8 b - -',
            '4k3/R7/8/8/8/5K2/8/8 w - -',
            '4k3/R7/8/8/4K3/8/8/8 b - -',
            '3k4/R7/8/8/4K3/8/8/8 w - -',
            '3k4/R7/8/3K4/8/8/8/8 b - -',
            '2k5/R7/8/3K4/8/8/8/8 w - -',
            '4k3/R7/8/3K4/8/8/8/8 w - -',
            '4k3/R7/3K4/8/8/8/8/8 b - -',
            '5k2/R7/3K4/8/8/8/8/8 w - -',
            '5k2/R7/4K3/8/8/8/8/8 b - -',
            '6k1/R7/4K3/8/8/8/8/8 w - -',
            '6k1/R7/5K2/8/8/8/8/8 b - -',
            '7k/R7/5K2/8/8/8/8/8 w - -',
            '7k/R7/6K1/8/8/8/8/8 b - -',
            '6k1/R7/6K1/8/8/8/8/8 w - -',
            'R5k1/8/6K1/8/8/8/8/8 b - -',
            '2k5/R7/3K4/8/8/8/8/8 b - -',
        ];

        $this->assertSame($expected, $fen);
    }

    /**
     * @test
     */
    public function fen_chess_fundamentals_Ra7_Kg8__Kd8()
    {
        $fen = '7k/8/8/8/8/8/8/R6K w - -';

        $movetext = '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8
            (5...Ke8 6.Kd6 Kf8 7.Ke6 Kg8 8.Kf6 Kh8 9.Kg6 Kg8 10.Ra8#)
            6.Kd6
            (6.Kc6 Kd8)';

        $board = (new StrToBoard($fen))->create();

        $fen = (new RavPlay($movetext, $board))->fen()->getFen();

        $expected = [
            '7k/8/8/8/8/8/8/R6K w - -',
            '7k/R7/8/8/8/8/8/7K b - -',
            '6k1/R7/8/8/8/8/8/7K w - -',
            '6k1/R7/8/8/8/8/6K1/8 b - -',
            '5k2/R7/8/8/8/8/6K1/8 w - -',
            '5k2/R7/8/8/8/5K2/8/8 b - -',
            '4k3/R7/8/8/8/5K2/8/8 w - -',
            '4k3/R7/8/8/4K3/8/8/8 b - -',
            '3k4/R7/8/8/4K3/8/8/8 w - -',
            '3k4/R7/8/3K4/8/8/8/8 b - -',
            '2k5/R7/8/3K4/8/8/8/8 w - -',
            '4k3/R7/8/3K4/8/8/8/8 w - -',
            '4k3/R7/3K4/8/8/8/8/8 b - -',
            '5k2/R7/3K4/8/8/8/8/8 w - -',
            '5k2/R7/4K3/8/8/8/8/8 b - -',
            '6k1/R7/4K3/8/8/8/8/8 w - -',
            '6k1/R7/5K2/8/8/8/8/8 b - -',
            '7k/R7/5K2/8/8/8/8/8 w - -',
            '7k/R7/6K1/8/8/8/8/8 b - -',
            '6k1/R7/6K1/8/8/8/8/8 w - -',
            'R5k1/8/6K1/8/8/8/8/8 b - -',
            '2k5/R7/3K4/8/8/8/8/8 b - -',
            '2k5/R7/2K5/8/8/8/8/8 b - -',
            '3k4/R7/2K5/8/8/8/8/8 w - -',
        ];

        $this->assertSame($expected, $fen);
    }

    /**
     * @test
     */
    public function fen_chess_fundamentals_Ra7_Kg8__Kb8()
    {
        $fen = '7k/8/8/8/8/8/8/R6K w - -';

        $movetext = '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8
            (5...Ke8 6.Kd6 Kf8 7.Ke6 Kg8 8.Kf6 Kh8 9.Kg6 Kg8 10.Ra8#)
            6.Kd6
            (6.Kc6 Kd8)
            6...Kb8';

        $board = (new StrToBoard($fen))->create();

        $fen = (new RavPlay($movetext, $board))->fen()->getFen();

        $expected = [
            '7k/8/8/8/8/8/8/R6K w - -',
            '7k/R7/8/8/8/8/8/7K b - -',
            '6k1/R7/8/8/8/8/8/7K w - -',
            '6k1/R7/8/8/8/8/6K1/8 b - -',
            '5k2/R7/8/8/8/8/6K1/8 w - -',
            '5k2/R7/8/8/8/5K2/8/8 b - -',
            '4k3/R7/8/8/8/5K2/8/8 w - -',
            '4k3/R7/8/8/4K3/8/8/8 b - -',
            '3k4/R7/8/8/4K3/8/8/8 w - -',
            '3k4/R7/8/3K4/8/8/8/8 b - -',
            '2k5/R7/8/3K4/8/8/8/8 w - -',
            '4k3/R7/8/3K4/8/8/8/8 w - -',
            '4k3/R7/3K4/8/8/8/8/8 b - -',
            '5k2/R7/3K4/8/8/8/8/8 w - -',
            '5k2/R7/4K3/8/8/8/8/8 b - -',
            '6k1/R7/4K3/8/8/8/8/8 w - -',
            '6k1/R7/5K2/8/8/8/8/8 b - -',
            '7k/R7/5K2/8/8/8/8/8 w - -',
            '7k/R7/6K1/8/8/8/8/8 b - -',
            '6k1/R7/6K1/8/8/8/8/8 w - -',
            'R5k1/8/6K1/8/8/8/8/8 b - -',
            '2k5/R7/3K4/8/8/8/8/8 b - -',
            '2k5/R7/2K5/8/8/8/8/8 b - -',
            '3k4/R7/2K5/8/8/8/8/8 w - -',
            '1k6/R7/3K4/8/8/8/8/8 w - -',
        ];

        $this->assertSame($expected, $fen);
    }

    /**
     * @test
     */
    public function fen_chess_fundamentals_Ra7_Kg8__Kd8_Ra8()
    {
        $fen = '7k/8/8/8/8/8/8/R6K w - -';

        $movetext = '1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8
            (5...Ke8 6.Kd6 Kf8 7.Ke6 Kg8 8.Kf6 Kh8 9.Kg6 Kg8 10.Ra8#)
            6.Kd6
            (6.Kc6 Kd8)
            6...Kb8
            (6...Kd8 7.Ra8#)';

        $board = (new StrToBoard($fen))->create();

        $fen = (new RavPlay($movetext, $board))->fen()->getFen();

        $expected = [
            '7k/8/8/8/8/8/8/R6K w - -',
            '7k/R7/8/8/8/8/8/7K b - -',
            '6k1/R7/8/8/8/8/8/7K w - -',
            '6k1/R7/8/8/8/8/6K1/8 b - -',
            '5k2/R7/8/8/8/8/6K1/8 w - -',
            '5k2/R7/8/8/8/5K2/8/8 b - -',
            '4k3/R7/8/8/8/5K2/8/8 w - -',
            '4k3/R7/8/8/4K3/8/8/8 b - -',
            '3k4/R7/8/8/4K3/8/8/8 w - -',
            '3k4/R7/8/3K4/8/8/8/8 b - -',
            '2k5/R7/8/3K4/8/8/8/8 w - -',
            '4k3/R7/8/3K4/8/8/8/8 w - -',
            '4k3/R7/3K4/8/8/8/8/8 b - -',
            '5k2/R7/3K4/8/8/8/8/8 w - -',
            '5k2/R7/4K3/8/8/8/8/8 b - -',
            '6k1/R7/4K3/8/8/8/8/8 w - -',
            '6k1/R7/5K2/8/8/8/8/8 b - -',
            '7k/R7/5K2/8/8/8/8/8 w - -',
            '7k/R7/6K1/8/8/8/8/8 b - -',
            '6k1/R7/6K1/8/8/8/8/8 w - -',
            'R5k1/8/6K1/8/8/8/8/8 b - -',
            '2k5/R7/3K4/8/8/8/8/8 b - -',
            '2k5/R7/2K5/8/8/8/8/8 b - -',
            '3k4/R7/2K5/8/8/8/8/8 w - -',
            '1k6/R7/3K4/8/8/8/8/8 w - -',
            '3k4/R7/3K4/8/8/8/8/8 w - -',
            'R2k4/8/3K4/8/8/8/8/8 b - -',
        ];

        $this->assertSame($expected, $fen);
    }

    /**
     * @test
     */
    public function fen_chess_fundamentals_Ke2_Kd5__Kc4()
    {
        $fen = '8/8/8/4k3/8/8/8/4K2R w - -';

        $movetext = '1.Ke2 Kd5 2.Ke3 Kc4';

        $board = (new StrToBoard($fen))->create();

        $fen = (new RavPlay($movetext, $board))->fen()->getFen();

        $expected = [
            '8/8/8/4k3/8/8/8/4K2R w - -',
            '8/8/8/4k3/8/8/4K3/7R b - -',
            '8/8/8/3k4/8/8/4K3/7R w - -',
            '8/8/8/3k4/8/4K3/8/7R b - -',
            '8/8/8/8/2k5/4K3/8/7R w - -',

        ];

        $this->assertSame($expected, $fen);
    }

    /**
     * @test
     */
    public function fen_chess_fundamentals_Ke2_Kd5__Ke5_Rh5()
    {
        $fen = '8/8/8/4k3/8/8/8/4K2R w - -';

        $movetext = '1.Ke2 Kd5 2.Ke3 Kc4
            (2...Ke5 3.Rh5+)';

        $board = (new StrToBoard($fen))->create();

        $fen = (new RavPlay($movetext, $board))->fen()->getFen();

        $expected = [
            '8/8/8/4k3/8/8/8/4K2R w - -',
            '8/8/8/4k3/8/8/4K3/7R b - -',
            '8/8/8/3k4/8/8/4K3/7R w - -',
            '8/8/8/3k4/8/4K3/8/7R b - -',
            '8/8/8/8/2k5/4K3/8/7R w - -',
            '8/8/8/4k3/8/4K3/8/7R w - -',
            '8/8/8/4k2R/8/4K3/8/8 b - -',
        ];

        $this->assertSame($expected, $fen);
    }

    /**
     * @test
     */
    public function fen_chess_fundamentals_Ke2_Kd5__Rh5()
    {
        $fen = '8/8/8/4k3/8/8/8/4K2R w - -';

        $movetext = '1.Ke2 Kd5 2.Ke3 Kc4
            (2...Ke5 3.Rh5+)
            3.Rh5';

        $board = (new StrToBoard($fen))->create();

        $fen = (new RavPlay($movetext, $board))->fen()->getFen();

        $expected = [
            '8/8/8/4k3/8/8/8/4K2R w - -',
            '8/8/8/4k3/8/8/4K3/7R b - -',
            '8/8/8/3k4/8/8/4K3/7R w - -',
            '8/8/8/3k4/8/4K3/8/7R b - -',
            '8/8/8/8/2k5/4K3/8/7R w - -',
            '8/8/8/4k3/8/4K3/8/7R w - -',
            '8/8/8/4k2R/8/4K3/8/8 b - -',
            '8/8/8/7R/2k5/4K3/8/8 b - -',
        ];

        $this->assertSame($expected, $fen);
    }

    /**
     * @test
     */
    public function fen_chess_fundamentals_Ke2_Kd5__Kb4_Kd3()
    {
        $fen = '8/8/8/4k3/8/8/8/4K2R w - -';

        $movetext = '1.Ke2 Kd5 2.Ke3 Kc4
            (2...Ke5 3.Rh5+)
            3.Rh5
            (3...Kb4 4.Kd3)';

        $board = (new StrToBoard($fen))->create();

        $fen = (new RavPlay($movetext, $board))->fen()->getFen();

        $expected = [
            '8/8/8/4k3/8/8/8/4K2R w - -',
            '8/8/8/4k3/8/8/4K3/7R b - -',
            '8/8/8/3k4/8/8/4K3/7R w - -',
            '8/8/8/3k4/8/4K3/8/7R b - -',
            '8/8/8/8/2k5/4K3/8/7R w - -',
            '8/8/8/4k3/8/4K3/8/7R w - -',
            '8/8/8/4k2R/8/4K3/8/8 b - -',
            '8/8/8/7R/2k5/4K3/8/8 b - -',
        ];

        $this->assertSame($expected, $fen);
    }
}
