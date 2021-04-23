<?php

namespace Chess\Tests\Unit\PGN\Validate;

use Chess\PGN\Symbol;
use Chess\PGN\Tag;
use Chess\PGN\Validate;
use Chess\Tests\AbstractUnitTestCase;

class TagTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function Foo_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        Validate::tag('Foo');
    }

    /**
     * @test
     */
    public function Event_Vladimir_Dvorkovich_Cup()
    {
        $tag = Validate::tag('[Event "Vladimir Dvorkovich Cup"]');

        $this->assertEquals('Event', $tag->name);
        $this->assertEquals('Vladimir Dvorkovich Cup', $tag->value);
    }

    /**
     * @test
     */
    public function Site_Saint_Louis_USA()
    {
        $tag = Validate::tag('[Site "Saint Louis USA"]');

        $this->assertEquals('Site', $tag->name);
        $this->assertEquals('Saint Louis USA', $tag->value);
    }

    /**
     * @test
     */
    public function Date_2018_05_10()
    {
        $tag = Validate::tag('[Date "2018.05.10"]');

        $this->assertEquals('Date', $tag->name);
        $this->assertEquals('2018.05.10', $tag->value);
    }

    /**
     * @test
     */
    public function Round_9_6()
    {
        $tag = Validate::tag('[Round "9.6"]');

        $this->assertEquals('Round', $tag->name);
        $this->assertEquals('9.6', $tag->value);
    }

    /**
     * @test
     */
    public function White_Kantor_Gergely()
    {
        $tag = Validate::tag('[White "Kantor, Gergely"]');

        $this->assertEquals('White', $tag->name);
        $this->assertEquals('Kantor, Gergely', $tag->value);
    }

    /**
     * @test
     */
    public function Black_Gelfand_Boris()
    {
        $tag = Validate::tag('[Black "Gelfand, Boris"]');

        $this->assertEquals('Black', $tag->name);
        $this->assertEquals('Gelfand, Boris', $tag->value);
    }

    /**
     * @test
     */
    public function Result_12_12()
    {
        $tag = Validate::tag('[Result "1/2-1/2"]');

        $this->assertEquals('Result', $tag->name);
        $this->assertEquals('1/2-1/2', $tag->value);
    }

    /**
     * @test
     */
    public function WhiteElo_2579()
    {
        $tag = Validate::tag('[WhiteElo "2579"]');

        $this->assertEquals('WhiteElo', $tag->name);
        $this->assertEquals('2579', $tag->value);
    }

    /**
     * @test
     */
    public function BlackElo_2474()
    {
        $tag = Validate::tag('[BlackElo "2474"]');

        $this->assertEquals('BlackElo', $tag->name);
        $this->assertEquals('2474', $tag->value);
    }

    /**
     * @test
     */
    public function ECO_D35()
    {
        $tag = Validate::tag('[ECO "D35"]');

        $this->assertEquals('ECO', $tag->name);
        $this->assertEquals('D35', $tag->value);
    }

    /**
     * @test
     */
    public function EventDate_2017_12_17()
    {
        $tag = Validate::tag('[EventDate "2017.12.17"]');

        $this->assertEquals('EventDate', $tag->name);
        $this->assertEquals('2017.12.17', $tag->value);
    }
}
