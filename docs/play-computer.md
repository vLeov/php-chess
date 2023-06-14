# Play Computer

📌 UCI engines not only allow to play chess with the computer but are also a helpful tool when analyzing chess games.

[Chess\UciEngine\Stockfish](https://github.com/chesslablab/php-chess/blob/master/tests/unit/UciEngine/StockfishTest.php) allows to play chess against the Stockfish chess engine.

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
