`Chess\Randomizer\Endgame\PawnEndgameRandomizer` creates a `Chess\Variant\Classical\Board` object representing a pawn endgame position as shown in the following example. For further information please check out the tests in [tests/unit/Randomizer/Endgame/PawnEndgameRandomizerTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Randomizer/Endgame/PawnEndgameRandomizerTest.php).

---

#### `public function getBoard()`

Returns a `Chess\Variant\Classical\Board` object representing a pawn endgame position.

```php
use Chess\Media\BoardToPng;
use Chess\PGN\AN\Color;
use Chess\Randomizer\Endgame\PawnEndgameRandomizer;

$board = (new PawnEndgameRandomizer($turn = Color::W))->getBoard();

$filename = (new BoardToPng($board, $flip = false))->output();
```

![Figure 3](https://raw.githubusercontent.com/chesslablab/php-chess/master/docs/randomizer-figure-03.png)
