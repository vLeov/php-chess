`Chess\UciEngine\Stockfish` allows to play chess against the Stockfish chess engine. Let's look at the methods available in this class through the following example. For further information please check out these [tests](https://github.com/chesslablab/php-chess/blob/master/tests/unit/UciEngine/StockfishTest.php).

```php
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

$lan = $stockfish->play($board->toFen());
$board->playLan('b', $lan);
```
---

#### `public function setOptions(array $options): Stockfish`

Set Stockfish options.

#### `public function setParams(array $params): Stockfish`

Sets the current command params.

#### `public function play(string $fen): string`

Returns Stockfish's move in LAN format.
