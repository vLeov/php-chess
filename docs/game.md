`Chess\Game` is the main component of the [PHP Chess Server](https://github.com/chesslablab/chess-server), it is basically a wrapper for the [`Chess\Board`](https://php-chess.readthedocs.io/en/latest/board/) intended to play chess online. Let's look at the methods available through some examples.

For further information please check out the tests in [tests/unit/GameTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/GameTest.php).

---

#### `public function play(string $color, string $pgn): bool`

Makes a move in PGN format.

```php
use Chess\Game;

$game = new Game();
$game->play('w', 'Nc3');
```

#### `public function playFen(string $toShortFen): bool|string`

Makes a move in short FEN format, only the piece placement and the side to move are required.

```php
use Chess\Game;

$game = new Game();
$game->playFen('rnb1kbnr/ppp1pppp/8/3q4/8/2N5/PPPP1PPP/R1BQKBNR b');
```

#### `public function loadFen(string $string): void`

Loads a FEN string to continue playing a game.

```php
use Chess\Game;

$game = new Game(Game::MODE_FEN);
$game->loadFen('rn1qkb1r/4pp1p/3p1np1/2pP4/4P3/2N3P1/PP3P1P/R1BQ1KNR b kq - 0 9');
$game->play('b', 'Bg7');
```

#### `public function loadPgn(string $movetext): void`

Loads a PGN movetext to continue playing a game.

```php
use Chess\Game;

$game = new Game(Game::MODE_PGN);
$game->loadPgn('1.e4 e6 2.d4 d5 3.Nc3 Nf6');
$game->play('w', 'e5');
```

#### `public function ai(array $options = [], array $params = []): ?object`

Returns a computer generated response to the current position. This method is to be used in either `Game::MODE_GM` or `Game::MODE_AI` otherwise it returns null.

```php
use Chess\Game;

$game = new Game(Game::MODE_GM, __DIR__.'/../data/players.json');
$game->play('w', 'e4');

$ai = $game->ai();
print_r($ai);
```
```
stdClass Object
(
    [move] => c5
    [game] => Array
        (
            [Event] => Wijk m
            [Site] => Wijk aan Zee
            [Date] => 1993.??.??
            [White] => Adams, Michael
            [Black] => Hodgson, Julian M
            [Result] => 1/2-1/2
            [ECO] => B99
            [movetext] => 1.e4 c5 2.Nc3 d6 3.Nge2 Nf6 4.d4 cxd4 5.Nxd4 a6 6.Bg5 e6 7.f4 Be7 8.Qf3 Qc7 9.O-O-O Nbd7 10.g4 b5 11.Bxf6 Nxf6 12.g5 Nd7 13.f5 Bxg5+ 14.Kb1 Ne5 15.Qh5 Qd8 16.Nxe6 Bxe6 17.fxe6 O-O 18.Bh3 g6 19.Qe2 fxe6 20.Bxe6+ Kh8 21.h4 Bf6 22.h5 g5 23.Rhf1 h6 24.Nd5 Bg7 25.Rxf8+ Qxf8 26.Rf1 Qd8 27.Ne3 Qe7 28.Bb3 Rf8 29.Nf5 Qf6 30.c3 g4 31.a3 Qg5 32.Rd1 Qxh5 33.Rxd6 Qg5 34.Rxa6 g3 35.Qg2 Nd3 36.Rd6 Nf4
        )

)
```
```php
use Chess\Game;

$game = new Game(Game::MODE_STOCKFISH, __DIR__.'/../data/players.json');
$game->play('w', 'e4');
$game->play('b', 'a4');
$game->play('w', 'd4');
$game->play('b', 'a5');
$game->play('w', 'Nf3');

$ai = $game->ai(['Skill Level' => 9], ['depth' => 3]);
print_r($ai);
```
```
stdClass Object
(
    [move] => e6
)
```

#### `public function state(): object`

Returns the state of the board.

```php
use Chess\Game;

$game = new Game();

$state = $game->state();
```

`$state` is a PHP object with information about the game being played.

| Property          | Description                                         |
|-------------------|-----------------------------------------------------|
| `turn`            | The current player's turn                           |
| `castlingAbility` | The castling ability in FEN format                  |
| `movetext`        | PGN movetext                                        |
| `fen`             | FEN string                                          |
| `isCheck`         | Checks out if the current player is in check        |
| `isMate`          | Checks out if the current player is checkmated      |
| `isStalemate`     | Checks out whether the current player is stalemated |

The properties of the  `$state` object are accessed this way:

```php
$game->state()->turn;
$game->state()->castlingAbility;
$game->state()->movetext;
$game->state()->fen;
$game->state()->isCheck;
$game->state()->isMate;
$game->state()->isStalemate;
```
