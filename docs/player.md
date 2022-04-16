`Chess\Player` allows to play a PGN movetext returning a [`Chess\Board`](https://php-chess.readthedocs.io/en/latest/board/) object as it is described in the following example.

For further information you may want to check out the tests in [tests/unit/PlayerTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/PlayerTest.php).

---

```php
use Chess\Player;

$movetext = '1.e4 c5 2.Nf3 d6 3.d4 cxd4 4.Nxd4 Nf6 5.Nc3';

$player = new Player($movetext);

$board = $player->play()->getBoard();
```

#### `public function play(): Player`

Plays a chess game.

#### `public function getBoard(): Board`

Returns the resulting `Chess\Board` object of playing a game.

#### `public function getMoves(): array`

Returns the PGN moves as an array.
