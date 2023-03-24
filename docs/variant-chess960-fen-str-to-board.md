`Chess\Variant\Chess960\FEN\StrToBoard` converts a Chess960 FEN string to a chess board object of type `Chess\Variant\Chess960\Board`. Let's look at the methods available in this class through the following example. For further information please check out the tests in [tests/unit/Variant/Chess960/FEN/StrToBoardTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Variant/Chess960/FEN/StrToBoardTest.php).

---

#### `public function create(): Board`

Returns a `Chess\Variant\Chess960\Board` object given a FEN string and a start position.

```php
use Chess\Variant\Chess960\FEN\StrToBoard;

$startPos = ['R', 'N', 'B', 'Q', 'K', 'B', 'N', 'R' ];

$board = (new StrToBoard(
    'rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3 0 1',
    $startPos
))->create();
```
