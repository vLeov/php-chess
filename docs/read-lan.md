# Read LAN

✨ Computers and graphical user interfaces (GUI) often prefer an easy-to-use, machine-readable format called Long Algebraic Notation.

Remember, if reading the main line of the Sicilian Defense from a JavaScript application, you may want to use the LAN format rather than the PGN format. Chances are that the JavaScript chessboard will be using the LAN format for move generation.

```php
use Chess\Variant\Classical\Board;

$board = new Board();
$board->playLan('w', 'e2e4');
$board->playLan('b', 'c7c5');
$board->playLan('w', 'g1f3');
$board->playLan('b', 'd7d6');
$board->playLan('w', 'd2d4');
$board->playLan('b', 'c5d4');
$board->playLan('w', 'f3d4');
$board->playLan('b', 'g8f6');

echo $board->getMovetext();
```

```text
1.e4 c5 2.Nf3 d6 3.d4 cxd4 4.Nxd4 Nf6
```

Also [Chess\Play\LanPlay](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Play/LanPlayTest.php) allows to easily play a bunch of LAN moves at once instead of one by one. As it name implies, this class is intended to play a LAN movetext.

```php
use Chess\Play\LanPlay;

$movetext = '1.e2e4 c7c5 2.g1f3 d7d6 3.d2d4 c5d4 4.f3d4 g8f6';

$board = (new LanPlay($movetext))
    ->validate()
    ->getBoard();

echo $board->toAsciiString();
```

```text
r  n  b  q  k  b  .  r
p  p  .  .  p  p  p  p
.  .  .  p  .  n  .  .
.  .  .  .  .  .  .  .
.  .  .  N  P  .  .  .
.  .  .  .  .  .  .  .
P  P  P  .  .  P  P  P
R  N  B  Q  K  B  .  R
```

🎉 And, it's easy! The UCI protocol enables chess engines to communicate with user interfaces using LAN for moves.
