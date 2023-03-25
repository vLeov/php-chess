<?php

namespace Chess\Tests\Unit\Media;

use Chess\Game;
use Chess\Media\BoardToMp4;
use Chess\Tests\AbstractUnitTestCase;

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

        $filename = (new BoardToMp4(
            Game::VARIANT_CLASSICAL,
            $A74
        ))->output(self::OUTPUT_FOLDER, 'A74');

        $this->assertSame(
            filesize(self::OUTPUT_FOLDER.'/'.$filename),
            filesize(self::DATA_FOLDER.'/mp4/A74.mp4')
        );
    }
}
