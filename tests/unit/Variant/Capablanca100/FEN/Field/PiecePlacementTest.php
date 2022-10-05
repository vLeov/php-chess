<?php

namespace Chess\Tests\Unit\Variant\Capablanca100\FEN\Field;

use Chess\Exception\UnknownNotationException;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca100\FEN\Field\PiecePlacement;

class PiecePlacementTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function validate_foobar()
    {
        $this->expectException(UnknownNotationException::class);

        PiecePlacement::validate('foobar');
    }

    /**
     * @test
     */
    public function validate_start_classical()
    {
        $this->expectException(UnknownNotationException::class);

        PiecePlacement::validate('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR');
    }

    /**
     * @test
     */
    public function validate_start_capablanca_100()
    {
        $expected = 'rnabqkbcnr/pppppppppp/10/10/10/10/10/10/PPPPPPPPPP/RNABQKBCNR';

        $this->assertSame(
            $expected,
            PiecePlacement::validate('rnabqkbcnr/pppppppppp/10/10/10/10/10/10/PPPPPPPPPP/RNABQKBCNR'
        ));
    }
}
