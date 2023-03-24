`Chess\Randomizer\Checkmate\TwoBishopsRandomizer` creates a chess board object representing an endgame position to deliver checkmate with two bishops as shown in the following example. For further information please check out these [tests](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Variant/Classical/Randomizer/Checkmate/TwoBishopsRandomizerTest.php).

---

#### `public function getBoard(): Board`

Returns a `Chess\Variant\Classical\Board` object representing an endgame position to deliver checkmate with two bishops.

```php
use Chess\Media\BoardToPng;
use Chess\PGN\AN\Color;
use Chess\Randomizer\Checkmate\TwoBishopsRandomizer;

$board = (new TwoBishopsRandomizer($turn = Color::B))->getBoard();

$filename = (new BoardToPng($board, $flip = true))->output();
```

![Figure 2](https://raw.githubusercontent.com/chesslablab/php-chess/master/docs/randomizer-figure-02.png)
