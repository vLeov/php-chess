Converts a [`Chess\Board`](https://php-chess.readthedocs.io/en/latest/board/) object to a FEN string.

Let's look at an example. For further information you may want to check out the tests in [tests/unit/FEN/BoardToStrTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/FEN/BoardToStrTest.php).

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
