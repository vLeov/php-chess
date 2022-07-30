`Chess\FEN\StrToPgn` allows to create a PGN move from two FEN strings, the first one representing an initial position and the second one a target position. For further information please check out the tests in [tests/unit/FEN/StrToPgnTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/FEN/StrToPgnTest.php).

---

#### `public function create(): array`

Creates a PGN move.

```php
use Chess\FEN\StrToPgn;

$pgn = (new StrToPgn(
    'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq -',
    'rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3'
))->create();

print_r($pgn);
```
```
Array
(
    [w] => e4
)
```
