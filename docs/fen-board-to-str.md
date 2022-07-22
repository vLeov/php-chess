`Chess\FEN\BoardToStr` allows to create a FEN string from a [`Chess\Board`](https://php-chess.readthedocs.io/en/latest/board/) object as shown in the following example. For further information please check out the tests in [tests/unit/FEN/BoardToStrTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/FEN/BoardToStrTest.php).

---

#### `public function create(): string`

Creates a FEN string.

```php
use Chess\Board;
use Chess\FEN\BoardToStr;

$board = new Board();
$board->play('w', 'e4');
$board->play('b', 'e5');

$string = (new BoardToStr($board))->create();

print_r($string);
```
```
rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq e6
```
