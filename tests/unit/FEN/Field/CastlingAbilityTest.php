<?php

namespace Chess\Tests\Unit\FEN\Field;

use Chess\Exception\UnknownNotationException;
use Chess\FEN\Field\CastlingAbility;
use Chess\Tests\AbstractUnitTestCase;

class CastlingAbilityTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function foobar()
    {
        $this->expectException(UnknownNotationException::class);

        CastlingAbility::validate('foobar');
    }

    /**
     * @test
     */
    public function start_b_kqKQ()
    {
        $this->expectException(UnknownNotationException::class);

        CastlingAbility::validate('kqKQ');
    }

    /**
     * @test
     */
    public function start_rearrange_KkQq()
    {
        $this->expectException(UnknownNotationException::class);

        CastlingAbility::validate('KkQq');
    }

    /**
     * @test
     */
    public function double_hyphen()
    {
        $this->expectException(UnknownNotationException::class);

        CastlingAbility::validate('--');
    }

    /**
     * @test
     */
    public function b_k_hyphen()
    {
        $this->expectException(UnknownNotationException::class);

        CastlingAbility::validate('k-');
    }

    /**
     * @test
     */
    public function empty_string()
    {
        $this->expectException(UnknownNotationException::class);

        CastlingAbility::validate('');
    }

    /**
     * @test
     */
    public function start_w_KQkq()
    {
        $this->assertSame('KQkq', CastlingAbility::validate('KQkq'));
    }

    /**
     * @test
     */
    public function w_k()
    {
        $this->assertSame('K', CastlingAbility::validate('K'));
    }

    /**
     * @test
     */
    public function w_q()
    {
        $this->assertSame('Q', CastlingAbility::validate('Q'));
    }

    /**
     * @test
     */
    public function b_k()
    {
        $this->assertSame('k', CastlingAbility::validate('k'));
    }

    /**
     * @test
     */
    public function b_q()
    {
        $this->assertSame('q', CastlingAbility::validate('q'));
    }

    /**
     * @test
     */
    public function w_kq()
    {
        $this->assertSame('KQ', CastlingAbility::validate('KQ'));
    }

    /**
     * @test
     */
    public function b_kq()
    {
        $this->assertSame('kq', CastlingAbility::validate('kq'));
    }

    /**
     * @test
     */
    public function hyphen()
    {
        $this->assertSame('-', CastlingAbility::validate('-'));
    }
}
