<?php

namespace Chess\Tests\Unit;

use Chess\Grandmaster;
use Chess\Tests\AbstractUnitTestCase;

class GrandmasterTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function w_response()
    {
        $filepath = __DIR__.'/../data/json/players.json';
        $response = (new Grandmaster($filepath))->response('');

        $this->assertNotEmpty($response);
    }

    /**
     * @test
     */
    public function b_response()
    {
        $filepath = __DIR__.'/../data/json/players.json';
        $response = (new Grandmaster($filepath))->response('1.e4');

        $this->assertNotEmpty($response);
    }
}
