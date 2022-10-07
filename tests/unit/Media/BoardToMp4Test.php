<?php

namespace Chess\Tests\Unit\Media;

use Chess\Media\BoardToMp4;
use Chess\Player\PgnPlayer;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Board;

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
    public function folder_does_not_exist()
    {
        $this->expectException(\InvalidArgumentException::class);

        $A74 = file_get_contents(self::DATA_FOLDER.'/sample/A74.pgn');

        $board = (new PgnPlayer($A74))->play()->getBoard();

        $filename = (new BoardToMp4($board))->output('foo');
    }
}
