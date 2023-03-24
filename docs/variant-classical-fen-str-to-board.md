`Chess\Variant\Classical\FEN\StrToBoard` converts a classical FEN string to a chess board object of type `Chess\Variant\Classical\Board`. Let's look at the methods available through the following example. For further information please check out the tests in [tests/unit/Variant/Classical/FEN/StrToBoardTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Variant/Classical/FEN/StrToBoardTest.php).

---

#### `public function create(): Board`

Returns a `Chess\Variant\Classical\Board` object given a FEN string.

```php
use Chess\Variant\Classical\FEN\StrToBoard;

$board = (new StrToBoard('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq e6 0 2'))
    ->create();
```
