`Chess\Media\BoardToMp4` converts a chess board object to an MP4 video. Let's look at the methods available in this class through the following example. For further information please check out these [tests](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Media/BoardToMp4Test.php).

---

#### `public function output(string $filepath, string $filename = ''): string`

Creates an MP4 video.

```php
use Chess\Game;
use Chess\Media\BoardToMp4;

$variant = Game::VARIANT_CLASSICAL;
$movetext = '1.e4 g5 2.d4 e6 3.c3 c5 4.dxc5 b6';

$filename = (new BoardToMp4($variant, $movetext))->output(__DIR__.'/../../storage/tmp');
```
