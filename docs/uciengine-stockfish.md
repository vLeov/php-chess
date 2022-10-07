`Chess\UciEngine\Stockfish` allows to play chess against the Stockfish chess engine. Let's look at the methods available through the following example. For further information please check out the tests in [tests/unit/UciEngine/StockfishTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/UciEngine/StockfishTest.php).

```php
use Chess\Variant\Classical\FEN\ShortStrToPgn;
use Chess\UciEngine\Stockfish;
use Chess\Variant\Classical\Board;

$board = new Board();
$board->play('w', 'e4');

$stockfish = (new Stockfish($board))
    ->setOptions([
        'Skill Level' => 9
    ])
    ->setParams([
        'depth' => 3
    ]);

$fromFen = $board->toFen();
$toFen = $stockfish->shortFen($fromFen);
$pgn = (new ShortStrToPgn($fromFen, $toFen))->create();

$board->play('b', current($pgn));
```

---

#### `public function setOptions(array $options): Stockfish`

Set Stockfish options.

#### `public function setParams(array $params): Stockfish`

Sets the current command params.

#### `public function shortFen(string $fen): string`

Makes the best move returning a short FEN string, only the piece placement and the side to move are returned.
