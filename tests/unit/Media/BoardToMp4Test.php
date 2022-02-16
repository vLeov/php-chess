<?php

namespace Chess\Tests\Unit\Media;

use Chess\Board;
use Chess\Media\BoardToMp4;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\FianchettoVariation as BenoniFianchettoVariation;

class BoardToMp4Test extends AbstractUnitTestCase
{
    const OUTPUT_FOLDER = __DIR__.'/../../output';

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

        $board = (new BenoniFianchettoVariation(new Board()))->play();

        $filename = (new BoardToMp4($board))->output('foo');
    }

    /**
     * @test
     */
    public function output_benoni_fianchetto_variation()
    {
        $board = (new BenoniFianchettoVariation(new Board()))->play();

        $filename = (new BoardToMp4($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER.'/mp4/benoni_fianchetto_variation.mp4')
        );
    }

    /**
     * @test
     */
    public function output_benoni_fianchetto_variation_flip()
    {
        $board = (new BenoniFianchettoVariation(new Board()))->play();

        $filename = (new BoardToMp4($board, $flip = true))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            md5_file(self::OUTPUT_FOLDER.'/'.$filename),
            md5_file(self::DATA_FOLDER . '/mp4/benoni_fianchetto_variation_flip.mp4')
        );
    }
}
