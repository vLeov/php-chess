`Chess\Variant\Classical\FEN\StrToBoard` allows to create a `Chess\Variant\Classical\Board` object from a FEN string as shown in the following example. For further information please check out the tests in [tests/unit/Variant/Classical/FEN/StrToBoardTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Variant/Classical/FEN/StrToBoardTest.php).

---

#### `public function create(): Board`

Creates a `Chess\Variant\Classical\Board` object.

```php
use Chess\Variant\Classical\FEN\StrToBoard;

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
