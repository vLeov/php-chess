`Chess\Variant\Classical\FEN\BoardToStr` allows to create a FEN string from a `Chess\Variant\Classical\Board` object as shown in the following example. For further information please check out the tests in [tests/unit/Variant/Classical/FEN/BoardToStrTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Variant/Classical/FEN/BoardToStrTest.php).

---

#### `public function create(): string`

Creates a FEN string.

```php
use Chess\Variant\Classical\FEN\BoardToStr;
use Chess\Variant\Classical\Board;

$board = new Board();
$board->play('w', 'e4');
$board->play('b', 'e5');

$string = (new BoardToStr($board))->create();

print_r($string);
```
```
rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq e6
```
