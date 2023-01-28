<?php

namespace Chess\Tests\Unit\Media;

use Chess\Media\JpgToPgnAn;
use Chess\Tests\AbstractUnitTestCase;

class JpgToPgnAnTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function predict_a1_52()
    {
        $filename = self::DATA_FOLDER.'/img/a1_52.jpg';

        $expected = 'empty';

        $this->assertSame($expected, (new JpgToPgnAn($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_b1_52()
    {
        $filename = self::DATA_FOLDER.'/img/b1_52.jpg';

        $expected = 'empty';

        $this->assertSame($expected, (new JpgToPgnAn($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_w_B_52()
    {
        $filename = self::DATA_FOLDER.'/img/B_52.jpg';

        $expected = 'B';

        $this->assertSame($expected, (new JpgToPgnAn($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_b_B_52()
    {
        $filename = self::DATA_FOLDER.'/img/b_52.jpg';

        $expected = 'b';

        $this->assertSame($expected, (new JpgToPgnAn($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_w_Q_52()
    {
        $filename = self::DATA_FOLDER.'/img/Q_52.jpg';

        $expected = 'Q';

        $this->assertSame($expected, (new JpgToPgnAn($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_b_Q_52()
    {
        $filename = self::DATA_FOLDER.'/img/q_52.jpg';

        $expected = 'q';

        $this->assertSame($expected, (new JpgToPgnAn($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_w_R_52()
    {
        $filename = self::DATA_FOLDER.'/img/R_52.jpg';

        $expected = 'R';

        $this->assertSame($expected, (new JpgToPgnAn($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_b_R_52()
    {
        $filename = self::DATA_FOLDER.'/img/r_52.jpg';

        $expected = 'r';

        $this->assertSame($expected, (new JpgToPgnAn($filename))->predict());
    }
}
