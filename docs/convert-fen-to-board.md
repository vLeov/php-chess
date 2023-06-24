# Convert FEN to Board

✨ FEN stands for Forsyth-Edwards Notation and is the standard way for describing chess positions using text strings.

Almost everything in PHP Chess can be done with a chessboard object. At some point you'll definitely want to convert a FEN string into a chessboard object for further processing, and this can be done with the [Chess\FenToBoard](https://github.com/chesslablab/php-chess/blob/master/src/FenToBoard.php) class according to the variants supported.

Let's continue a classical game from the FEN position of B54, which is the ECO code for "Sicilian Defense: Modern Variations, Main Line" previously discussed in [Read PGN](https://php-chess.readthedocs.io/en/latest/read-pgn/).

```php
use Chess\FenToBoard;

$board = FenToBoard::create('rnbqkb1r/pp2pppp/3p1n2/8/3NP3/8/PPP2PPP/RNBQKB1R w KQkq -');

$board->play('w', 'Nc3');
$board->play('b', 'Nc6');

echo $board->toFen();
```

```text
r1bqkb1r/pp2pppp/2np1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -
```

It is worth saying that after 5.Nc3 Nc6, B54 has turned into B56 which is the ECO code for "Sicilian Defense: Classical Variation" and the history contains two moves only.

```php
var_dump($board->getHistory());
```

```text
array(2) {
  [0]=>
  object(stdClass)#323 (4) {
    ["castlingAbility"]=>
    string(4) "KQkq"
    ["sq"]=>
    string(2) "b1"
    ["move"]=>
    object(stdClass)#2 (7) {
      ["pgn"]=>
      string(3) "Nc3"
      ["isCapture"]=>
      bool(false)
      ["isCheck"]=>
      bool(false)
      ["type"]=>
      string(48) "N[a-h]{0,1}[1-8]{0,1}[a-h]{1}[1-8]{1}[\+\#]{0,1}"
      ["color"]=>
      string(1) "w"
      ["id"]=>
      string(1) "N"
      ["sq"]=>
      object(stdClass)#3 (2) {
        ["current"]=>
        string(0) ""
        ["next"]=>
        string(2) "c3"
      }
    }
    ["fen"]=>
    string(59) "rnbqkb1r/pp2pppp/3p1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R b KQkq -"
  }
  [1]=>
  object(stdClass)#581 (4) {
    ["castlingAbility"]=>
    string(4) "KQkq"
    ["sq"]=>
    string(2) "b8"
    ["move"]=>
    object(stdClass)#82 (7) {
      ["pgn"]=>
      string(3) "Nc6"
      ["isCapture"]=>
      bool(false)
      ["isCheck"]=>
      bool(false)
      ["type"]=>
      string(48) "N[a-h]{0,1}[1-8]{0,1}[a-h]{1}[1-8]{1}[\+\#]{0,1}"
      ["color"]=>
      string(1) "b"
      ["id"]=>
      string(1) "N"
      ["sq"]=>
      object(stdClass)#59 (2) {
        ["current"]=>
        string(0) ""
        ["next"]=>
        string(2) "c6"
      }
    }
    ["fen"]=>
    string(60) "r1bqkb1r/pp2pppp/2np1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -"
  }
}
```

The initial FEN string is always accessible through the `getStartFen()` method.

```php
echo $board->getStartFen();
```

```text
rnbqkb1r/pp2pppp/3p1n2/8/3NP3/8/PPP2PPP/RNBQKB1R w KQkq -
```

🎉 Well done! You just learned a well-known and frequently played chess opening.
