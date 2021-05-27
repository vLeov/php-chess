<?php

namespace Chess\Tests\Unit\PGN;

use Chess\PGN\Movetext;
use Chess\Tests\AbstractUnitTestCase;

class MovetextTest extends AbstractUnitTestCase
{
    /**
     * @dataProvider orderData
     * @test
     */
    public function get_order(string $text)
    {
        $order = (new Movetext($text))->getOrder();

        $expected = (object) [
            'n' => [ 1, 2, 3, 4, 5, 6, 7 ],
            'move' => [ 'd4', 'Nf6', 'Nf3', 'e6', 'c4', 'Bb4+', 'Nbd2', 'O-O', 'a3', 'Be7', 'e4', 'd6', 'Bd3', 'c5' ],
        ];

        $this->assertEquals($expected, $order);
    }

    /**
     * @dataProvider sequenceData
     * @test
     */
    public function sequence($text, $expected)
    {
        $this->assertEquals($expected, (new Movetext($text))->sequence());
    }

    public function orderData()
    {
        return [
            [
                '1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5',
            ],
        ];
    }

    public function sequenceData()
    {
        return [
            [
                '1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5', [
                    '1.d4 Nf6',
                    '1.d4 Nf6 2.Nf3 e6',
                    '1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+',
                    '1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O',
                    '1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7',
                    '1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6',
                    '1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5',
                ],
            ],
            [
                '1.e4 Nf6 2.e5 Nd5 3.d4 d6 4.Nf3 dxe5 5.Nxe5 c6 6.Be2 Bf5 7.c3 Nd7', [
                    '1.e4 Nf6',
                    '1.e4 Nf6 2.e5 Nd5',
                    '1.e4 Nf6 2.e5 Nd5 3.d4 d6',
                    '1.e4 Nf6 2.e5 Nd5 3.d4 d6 4.Nf3 dxe5',
                    '1.e4 Nf6 2.e5 Nd5 3.d4 d6 4.Nf3 dxe5 5.Nxe5 c6',
                    '1.e4 Nf6 2.e5 Nd5 3.d4 d6 4.Nf3 dxe5 5.Nxe5 c6 6.Be2 Bf5',
                    '1.e4 Nf6 2.e5 Nd5 3.d4 d6 4.Nf3 dxe5 5.Nxe5 c6 6.Be2 Bf5 7.c3 Nd7',
                ],
            ]
        ];
    }
}
