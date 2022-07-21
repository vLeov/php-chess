`Chess\UciEngine\Stockfish` allows to play chess against the Stockfish chess engine as shown in the following example.

For further information please check out the tests in [tests/unit/UciEngine/StockfishTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/UciEngine/StockfishTest.php).

```php
use Chess\Board;
use Chess\FEN\ShortStrToPgn;
use Chess\UciEngine\Stockfish;

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
