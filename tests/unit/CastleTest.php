<?php

namespace Chess\Tests\Unit;

use Chess\Castle;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;

class CastleTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function w_O_O_O()
    {
        $rule = Castle::color(Symbol::WHITE);

        $this->assertSame($rule[Symbol::K][Symbol::O_O_O]['sqs']['b'], 'b1');
        $this->assertSame($rule[Symbol::K][Symbol::O_O_O]['sqs']['c'], 'c1');
        $this->assertSame($rule[Symbol::K][Symbol::O_O_O]['sqs']['d'], 'd1');
        $this->assertSame($rule[Symbol::K][Symbol::O_O_O]['sq']['current'], 'e1');
        $this->assertSame($rule[Symbol::K][Symbol::O_O_O]['sq']['next'], 'c1');
        $this->assertSame($rule[Symbol::R][Symbol::O_O_O]['sq']['current'], 'a1');
        $this->assertSame($rule[Symbol::R][Symbol::O_O_O]['sq']['next'], 'd1');
    }

    /**
     * @test
     */
    public function b_O_O_O()
    {
        $rule = Castle::color(Symbol::BLACK);

        $this->assertSame($rule[Symbol::K][Symbol::O_O_O]['sqs']['b'], 'b8');
        $this->assertSame($rule[Symbol::K][Symbol::O_O_O]['sqs']['c'], 'c8');
        $this->assertSame($rule[Symbol::K][Symbol::O_O_O]['sqs']['d'], 'd8');
        $this->assertSame($rule[Symbol::K][Symbol::O_O_O]['sq']['current'], 'e8');
        $this->assertSame($rule[Symbol::K][Symbol::O_O_O]['sq']['next'], 'c8');
        $this->assertSame($rule[Symbol::R][Symbol::O_O_O]['sq']['current'], 'a8');
        $this->assertSame($rule[Symbol::R][Symbol::O_O_O]['sq']['next'], 'd8');
    }

    /**
     * @test
     */
    public function w_O_O()
    {
        $rule = Castle::color(Symbol::WHITE);

        $this->assertSame($rule[Symbol::K][Symbol::O_O]['sqs']['f'], 'f1');
        $this->assertSame($rule[Symbol::K][Symbol::O_O]['sqs']['g'], 'g1');
        $this->assertSame($rule[Symbol::K][Symbol::O_O]['sq']['current'], 'e1');
        $this->assertSame($rule[Symbol::K][Symbol::O_O]['sq']['next'], 'g1');
        $this->assertSame($rule[Symbol::R][Symbol::O_O]['sq']['current'], 'h1');
        $this->assertSame($rule[Symbol::R][Symbol::O_O]['sq']['next'], 'f1');
    }

    /**
     * @test
     */
    public function b_O_O()
    {
        $rule = Castle::color(Symbol::BLACK);

        $this->assertSame($rule[Symbol::K][Symbol::O_O]['sqs']['f'], 'f8');
        $this->assertSame($rule[Symbol::K][Symbol::O_O]['sqs']['g'], 'g8');
        $this->assertSame($rule[Symbol::K][Symbol::O_O]['sq']['current'], 'e8');
        $this->assertSame($rule[Symbol::K][Symbol::O_O]['sq']['next'], 'g8');
        $this->assertSame($rule[Symbol::R][Symbol::O_O]['sq']['current'], 'h8');
        $this->assertSame($rule[Symbol::R][Symbol::O_O]['sq']['next'], 'f8');
    }
}
