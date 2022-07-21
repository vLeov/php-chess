`Chess\FEN\ShortStrToPgn` allows to create a PGN move from two FEN strings, the first one representing an initial position and the second one a target position. The short FEN format is used to describe the target position as shown in the following example.

For further information please check out the tests in [tests/unit/FEN/ShortStrToPgnTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/FEN/ShortStrToPgnTest.php).

---

#### `public function create(): array`

Creates a PGN move.

```php
use Chess\FEN\ShortStrToPgn;

$pgn = (new ShortStrToPgn(
    'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq -',
    'rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b'
))->create();

print_r($pgn);
```
```
Array
(
    [w] => e4
)
```
