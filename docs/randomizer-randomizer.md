`Chess\Randomizer\Randomizer` creates a [`Chess\Board`](https://php-chess.readthedocs.io/en/latest/board/) object with random pieces as shown in the following example. For further information please check out the tests in [tests/unit/Randomizer/RandomizerTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Randomizer/RandomizerTest.php).

---

#### `public function getBoard()`

Returns a `Chess\Board` object with random pieces.

```php
use Chess\Media\BoardToPng;
use Chess\PGN\AN\Color;
use Chess\Randomizer\Randomizer;

$turn = Color::B;

$items = [
    Color::B => ['N', 'B', 'R'],
];

$board = (new Randomizer($turn, $items))->getBoard();

$filename = (new BoardToPng($board, $flip = true))->output();
```

![Figure 1](https://raw.githubusercontent.com/chesslablab/php-chess/master/docs/randomizer-figure-01.png)
