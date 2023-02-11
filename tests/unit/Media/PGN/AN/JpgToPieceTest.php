<?php

namespace Chess\Tests\Unit\Media\PGN\AN;

use Chess\Media\PGN\AN\JpgToPiece;
use Chess\Tests\AbstractUnitTestCase;

class JpgToPieceTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function predict_a1_52()
    {
        $filename = self::DATA_FOLDER.'/img/a1_52.jpg';

        $expected = '1';

        $this->assertSame($expected, (new JpgToPiece($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_w_B_52()
    {
        $filename = self::DATA_FOLDER.'/img/B_52.jpg';

        $expected = 'B';

        $this->assertSame($expected, (new JpgToPiece($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_b_B_52()
    {
        $filename = self::DATA_FOLDER.'/img/b_52.jpg';

        $expected = 'b';

        $this->assertSame($expected, (new JpgToPiece($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_b_N_60()
    {
        $filename = self::DATA_FOLDER.'/img/n_60.jpg';

        $expected = 'n';

        $this->assertSame($expected, (new JpgToPiece($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_b_P_48()
    {
        $filename = self::DATA_FOLDER.'/img/P_48.jpg';

        $expected = 'P';

        $this->assertSame($expected, (new JpgToPiece($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_b_P_60()
    {
        $filename = self::DATA_FOLDER.'/img/p_60.jpg';

        $expected = 'p';

        $this->assertSame($expected, (new JpgToPiece($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_w_Q_48()
    {
        $filename = self::DATA_FOLDER.'/img/Q_48.jpg';

        $expected = 'Q';

        $this->assertSame($expected, (new JpgToPiece($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_w_Q_52()
    {
        $filename = self::DATA_FOLDER.'/img/Q_52.jpg';

        $expected = 'Q';

        $this->assertSame($expected, (new JpgToPiece($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_b_Q_52()
    {
        $filename = self::DATA_FOLDER.'/img/q_52.jpg';

        $expected = 'q';

        $this->assertSame($expected, (new JpgToPiece($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_w_R_52()
    {
        $filename = self::DATA_FOLDER.'/img/R_52.jpg';

        $expected = 'R';

        $this->assertSame($expected, (new JpgToPiece($filename))->predict());
    }

    /**
     * @test
     */
    public function predict_b_R_52()
    {
        $filename = self::DATA_FOLDER.'/img/r_52.jpg';

        $expected = 'r';

        $this->assertSame($expected, (new JpgToPiece($filename))->predict());
    }
}
