This is a chess board representation that allows to play chess in Portable Game Notation (PGN) format. It is a cornerstone allowing to build multiple features on top of it: FEN string generation, ASCII representation, PNG image creation, position evaluation, etc.

Let's look at the methods available through the following example.

```php
use Chess\Board;

$board = new Board();

$board->play('w', 'e4');
$board->play('b', 'd5');
$board->play('w', 'exd5');
$board->play('b', 'Qxd5');
```

For further details you may want to check out the tests in [unit/tests/BoardTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/BoardTest.php).

---

Get the pieces captured by both players.

```php
$captures = $board->getCaptures();

var_export($captures);
```
```text
array (
  'w' =>
  array (
    0 =>
    (object) array(
       'capturing' =>
      (object) array(
         'id' => 'P',
         'sq' => 'e4',
      ),
       'captured' =>
      (object) array(
         'id' => 'P',
         'sq' => 'd5',
      ),
    ),
  ),
  'b' =>
  array (
    0 =>
    (object) array(
       'capturing' =>
      (object) array(
         'id' => 'Q',
         'sq' => 'd8',
      ),
       'captured' =>
      (object) array(
         'id' => 'P',
         'sq' => 'd5',
      ),
    ),
  ),
)
```

Get the castle status.

```php
$castle = $board->getCastle();

var_export($castle);
```
```text
array (
  'w' =>
  array (
    'isCastled' => false,
    'O-O' => true,
    'O-O-O' => true,
  ),
  'b' =>
  array (
    'isCastled' => false,
    'O-O' => true,
    'O-O-O' => true,
  ),
)
```

Get the history.

```php
$history = $board->getHistory();

var_export($history);
```
```text
array (
  0 =>
  (object) array(
     'pgn' => 'e4',
     'color' => 'w',
     'id' => 'P',
     'sq' => 'e2',
     'isCapture' => false,
     'isCheck' => false,
  ),
  1 =>
  (object) array(
     'pgn' => 'd5',
     'color' => 'b',
     'id' => 'P',
     'sq' => 'd7',
     'isCapture' => false,
     'isCheck' => false,
  ),
  2 =>
  (object) array(
     'pgn' => 'exd5',
     'color' => 'w',
     'id' => 'P',
     'sq' => 'e4',
     'isCapture' => true,
     'isCheck' => false,
  ),
  3 =>
  (object) array(
     'pgn' => 'Qxd5',
     'color' => 'b',
     'id' => 'Q',
     'sq' => 'd8',
     'isCapture' => true,
     'isCheck' => false,
  ),
)
```

Get the movetext.

```php
$movetext = $board->getMovetext();

var_export($movetext);
```
```text
'1.e4 d5 2.exd5 Qxd5'
```

Get the current turn.

```php
$turn = $board->getTurn();

var_export($turn);
```
```text
'w'
```

Check out whether the current player is in check.

```php
$isCheck = $board->isCheck();

var_export($isCheck);
```
```text
false
```

Check out whether the current player is checkmated.

```php
$isMate = $board->isMate();

var_export($isMate);
```
```text
false
```

Check out whether the current player is stalemated.

```php
$isStalemate = $board->isStalemate();

var_export($isStalemate);
```
```text
false
```

Make a move.

```php
$board->play('w', 'Nc3');

var_export($board->getMovetext());
```
```text
'1.e4 d5 2.exd5 Qxd5 3.Nc3'
```
