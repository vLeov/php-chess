<?php

namespace Chess\Tests\Unit\Piece;

use Chess\Piece\B;
use Chess\Tests\AbstractUnitTestCase;

class BTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function mobility_a2()
    {
        $bishop = new B('w', 'a2');
        $mobility = (object) [
            'upLeft' => [],
            'upRight' => ['b3', 'c4', 'd5', 'e6', 'f7', 'g8'],
            'downLeft' => [],
            'downRight' => ['b1']
        ];

        $this->assertEquals($mobility, $bishop->getMobility());
    }

    /**
     * @test
     */
    public function mobility_d5()
    {
        $bishop = new B('w', 'd5');
        $mobility = (object) [
            'upLeft' => ['c6', 'b7', 'a8'],
            'upRight' => ['e6', 'f7', 'g8'],
            'downLeft' => ['c4', 'b3', 'a2'],
            'downRight' => ['e4', 'f3', 'g2', 'h1']
        ];

        $this->assertEquals($mobility, $bishop->getMobility());
    }

    /**
     * @test
     */
    public function mobility_a8()
    {
        $bishop = new B('w', 'a8');
        $mobility = (object) [
            'upLeft' => [],
            'upRight' => [],
            'downLeft' => [],
            'downRight' => ['b7', 'c6', 'd5', 'e4', 'f3', 'g2', 'h1']
        ];

        $this->assertEquals($mobility, $bishop->getMobility());
    }
}
