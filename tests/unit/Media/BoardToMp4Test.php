<?php

namespace Chess\Tests\Unit\Media;

use Chess\Media\BoardToMp4;
use Chess\Player\PgnPlayer;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca80\Board as Capablanca80Board;
use Chess\Variant\Chess960\Board as Chess960Board;

class BoardToMp4Test extends AbstractUnitTestCase
{
    const OUTPUT_FOLDER = __DIR__.'/../../tmp';

    public static function tearDownAfterClass(): void
    {
        array_map('unlink', glob(self::OUTPUT_FOLDER . '/*.mp4'));
    }

    /**
     * @test
     */
    public function folder_does_not_exist()
    {
        $this->expectException(\InvalidArgumentException::class);

        $A74 = file_get_contents(self::DATA_FOLDER.'/sample/A74.pgn');

        $board = (new PgnPlayer($A74))->play()->getBoard();

        $filename = (new BoardToMp4($board))->output('foo');
    }

    /**
     * @test
     */
    public function output_A74()
    {
        $A74 = file_get_contents(self::DATA_FOLDER.'/sample/A74.pgn');

        $board = (new PgnPlayer($A74))->play()->getBoard();

        $filename = (new BoardToMp4($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/mp4/A74.mp4')
        );
    }

    /**
     * @test
     */
    public function output_C30_960()
    {
        $C30 = file_get_contents(self::DATA_FOLDER.'/sample/C30.pgn');

        $board960 = new Chess960Board(['N', 'B', 'Q', 'N', 'R', 'K', 'B', 'R']);

        $board = (new PgnPlayer($C30, $board960))->play()->getBoard();

        $filename = (new BoardToMp4($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/mp4/C30_960.mp4')
        );
    }

    /**
     * @test
     */
    public function output_C30_capablanca80()
    {
        $C30 = file_get_contents(self::DATA_FOLDER.'/sample/C30.pgn');

        $boardCapablanca80 = new Capablanca80Board();

        $board = (new PgnPlayer($C30, $boardCapablanca80))->play()->getBoard();

        $filename = (new BoardToMp4($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/mp4/C30_capablanca80.mp4')
        );
    }
}
