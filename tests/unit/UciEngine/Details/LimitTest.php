<?php

namespace Chess\Tests\Unit\UciEngine\Details;

use Chess\Tests\AbstractUnitTestCase;
use Chess\UciEngine\Details\Limit;

class LimitTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function instantiation()
    {
        $limit = new Limit();

        $this->assertTrue(is_a($limit, Limit::class));
        $this->assertSame(null, $limit->getMovetime());
        $this->assertSame(null, $limit->getDepth());
        $this->assertSame(null, $limit->getNodes());
        $this->assertSame(null, $limit->getMate());
        $this->assertSame(null, $limit->getWtime());
        $this->assertSame(null, $limit->getBtime());
        $this->assertSame(null, $limit->getWinc());
        $this->assertSame(null, $limit->getBinc());
        $this->assertSame(null, $limit->getMovestogo());
    }

    /**
     * @test
     */
    public function time_3000()
    {
        $limit = (new Limit())->setMovetime(3000);

        $this->assertSame(3000, $limit->getMovetime());
    }
}
