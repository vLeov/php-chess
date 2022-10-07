`Chess\Media\BoardToPng` converts a `Chess\Variant\Classical\Board` object to a PNG image. Let's look at the methods available through the following example. For further information please check out the tests in [tests/unit/Media/BoardToPngTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Media/BoardToPngTest.php).

---

#### `public function output(string $filepath, string $salt = ''): string`

Creates a PNG image with a randomish filename, for example `620a7d61dcf57.png`.

```php
use Chess\Variant\Classical\FEN\StrToBoard;
use Chess\Media\BoardToPng;

$fen = '1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K w - - bm Nf6+';

$board = (new StrToBoard($fen))->create();

$filename = (new BoardToPng($board, $flip = true))->output();
```

![Figure 1](https://raw.githubusercontent.com/chesslablab/php-chess/master/tests/data/img/01_kaufman_flip.png)
