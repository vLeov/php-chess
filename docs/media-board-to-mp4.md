Converts a [`Chess\Board`](https://php-chess.readthedocs.io/en/latest/board/) object to an MP4 video.

Let's look at an example. For further information you may want to check out the tests in [tests/unit/Media/BoardToMp4Test.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Media/BoardToMp4Test.php).

---

#### `public function output(string $filepath): string`

Creates an MP4 video with a randomish filename, for example `620a7d61dcf57.mp4`.

```php
use Chess\Board;
use Chess\Media\BoardToMp4;

$board = new Board();
$board->play('w', 'e4');
$board->play('b', 'd5');
$board->play('w', 'exd5');
$board->play('b', 'Qxd5');

$filename = (new BoardToMp4($board, $flip = true))->output();
```
