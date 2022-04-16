Converts a [`Chess\Board`](https://php-chess.readthedocs.io/en/latest/board/) object to a JPG image.

Let's look at an example.

---

#### `public function output(string $filepath, string $salt = ''): string`

Creates a JPG image with a randomish filename, for example `620a7d61dcf57.jpg`.

```php
use Chess\FEN\StrToBoard;
use Chess\Media\BoardToJpg;

$fen = '1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K w - - bm Nf6+';

$board = (new StrToBoard($fen))->create();

$filename = (new BoardToJpg($board, $flip = true))->output();
```

![Figure 1](https://raw.githubusercontent.com/chesslablab/php-chess/master/tests/data/img/01_kaufman_flip.png)
Figure 1. Position 1 of the Kaufman test
