# Convert Board to MP4 Video

📝 Text-based PGN movetexts can be easily converted to MP4, a widely-used video format which comes in handy for pausing the games.

[Chess\Media\BoardToMp4](https://github.com/chesslablab/php-chess/blob/ac99506b7e09a30f61d6ad3b0a1d6436b4985226/tests/unit/Media/BoardToMp4Test.php) allows to convert a chess board object to an MP4 video.

```php
use Chess\Media\BoardToMp4;
use Chess\Variant\Classical\Board;

$movetext = '1.d4 Nf6 2.c4 c5 3.d5 e6 4.Nc3 exd5 5.cxd5 d6 6.e4 g6 7.Nf3 Bg7';

$filename = (new BoardToMp4(
    Board::VARIANT,
    $movetext
))->output(__DIR__.'/../../storage/tmp');
```

🎉 Done! Now you can share your favorite games with friends.
