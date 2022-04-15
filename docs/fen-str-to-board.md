Converts a FEN string to a [`Chess\Board`](https://php-chess.readthedocs.io/en/latest/board/) object.

Let's look at an example. For further information you may want to check out the tests in [tests/unit/FEN/StrToBoardTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/FEN/StrToBoardTest.php).

---

#### `public function create(): Board`

Creates a `Chess\Board` object.

```php
use Chess\FEN\StrToBoard;

$fen = 'rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3 0 1';

$board = (new StrToBoard($fen))->create();

$board->play('b', 'e5');

print_r($board->toAsciiString());
```
```
 r  n  b  q  k  b  n  r
 p  p  p  p  .  p  p  p
 .  .  .  .  .  .  .  .
 .  .  .  .  p  .  .  .
 .  .  .  .  P  .  .  .
 .  .  .  .  .  .  .  .
 P  P  P  P  .  P  P  P
 R  N  B  Q  K  B  N  R
```
