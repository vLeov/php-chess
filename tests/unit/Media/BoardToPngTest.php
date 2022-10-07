<?php

namespace Chess\Tests\Unit\Media;

use Chess\Media\BoardToPng;
use Chess\Player\PgnPlayer;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca80\Board as Capablanca80Board;
use Chess\Variant\Capablanca100\Board as Capablanca100Board;
use Chess\Variant\Classical\FEN\StrToBoard as ClassicalFenStrToBoard;
use Chess\Variant\Classical\Board as ClassicalBoard;

class BoardToPngTest extends AbstractUnitTestCase
{
    const OUTPUT_FOLDER = __DIR__.'/../../tmp';

    public static function tearDownAfterClass(): void
    {
        array_map('unlink', glob(self::OUTPUT_FOLDER . '/*.png'));
    }

    /**
     * @test
     */
    public function output_start()
    {
        $board = new ClassicalBoard();

        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/img/start.png')
        );
    }

    /**
     * @test
     */
    public function output_01_kaufman()
    {
        $fen = '1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K w - - bm Nf6+';

        $board = (new ClassicalFenStrToBoard($fen))->create();

        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/img/01_kaufman.png')
        );
    }

    /**
     * @test
     */
    public function output_01_kaufman_flip()
    {
        $fen = '1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K w - - bm Nf6+';

        $board = (new ClassicalFenStrToBoard($fen))->create();

        $filename = (new BoardToPng($board, $flip = true))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/img/01_kaufman_flip.png')
        );
    }

    /**
     * @test
     */
    public function output_02_kaufman()
    {
        $fen = '3r2k1/p2r1p1p/1p2p1p1/q4n2/3P4/PQ5P/1P1RNPP1/3R2K1 b - - bm Nxd4';

        $board = (new ClassicalFenStrToBoard($fen))->create();

        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/img/02_kaufman.png')
        );
    }

    /**
     * @test
     */
    public function output_A59()
    {
        $A59 = file_get_contents(self::DATA_FOLDER.'/sample/A59.pgn');

        $board = (new PgnPlayer($A59))->play()->getBoard();

        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/img/A59.png')
        );
    }

    /**
     * @test
     */
    public function output_A59_flip()
    {
        $A59 = file_get_contents(self::DATA_FOLDER.'/sample/A59.pgn');

        $board = (new PgnPlayer($A59))->play()->getBoard();

        $filename = (new BoardToPng($board, $flip = true))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/img/A59_flip.png')
        );
    }

    /**
     * @test
     */
    public function output_D06()
    {
        $D06 = file_get_contents(self::DATA_FOLDER.'/sample/D06.pgn');

        $board = (new PgnPlayer($D06))->play()->getBoard();

        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/img/symmetrical_defense_to_the_queens_gambit.png')
        );
    }

    /**
     * @test
     */
    public function output_D06_flip()
    {
        $D06 = file_get_contents(self::DATA_FOLDER.'/sample/D06.pgn');

        $board = (new PgnPlayer($D06))->play()->getBoard();

        $filename = (new BoardToPng($board, $flip = true))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/img/symmetrical_defense_to_the_queens_gambit_flip.png')
        );
    }

    /**
     * @test
     */
    public function output_start_capablanca100()
    {
        $board = new Capablanca100Board();

        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/img/start_capablanca_100.png')
        );
    }

    /**
     * @test
     */
    public function output_start_capablanca80()
    {
        $board = new Capablanca80Board();

        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/img/start_capablanca_80.png')
        );
    }
}
