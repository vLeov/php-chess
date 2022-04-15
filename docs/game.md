`Chess\Game` is the main component of the [PHP Chess Server](https://github.com/chesslablab/chess-server).

Let's look at the methods available through some examples. For further information you may want to check out the tests in [tests/unit/GameTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/GameTest.php).

#### `public function play(string $color, string $pgn): bool`

Makes a move.

```php
$game->play('w', 'Nc3');
```

#### `public function playFen(string $toShortFen): bool|string`

Makes a move in short FEN format. Only the piece placement and the side to move are required.

```php
$game->playFen('rnb1kbnr/ppp1pppp/8/3q4/8/2N5/PPPP1PPP/R1BQKBNR b');
```

#### `public function loadFen(string $string): void`

Load a FEN string to continue playing a chess game.

```php
$game = new Game(Game::MODE_LOAD_FEN);
$game->loadFen('rn1qkb1r/4pp1p/3p1np1/2pP4/4P3/2N3P1/PP3P1P/R1BQ1KNR b kq - 0 9');
$game->play('b', 'Bg7');
```

#### `public function loadPgn(string $movetext): void`

Load a PGN movetext to continue playing a chess game.

```php
$game = new Game(Game::MODE_LOAD_PGN);
$game->loadPgn('1.e4 e6 2.d4 d5 3.Nc3 Nf6');
$game->play('w', 'e5');
```

#### `public function piece(string $sq): ?object`

Obtain information about a piece by its position on the board.

```php
$piece = $game->piece('d5');

var_export($piece);
```

`$piece` is a PHP object with information about the piece selected.

| Property    | Description                          |
|-------------|--------------------------------------|
| `color`     | The piece's color in PGN format      |
| `id`        | The piece's id in PGN format         |
| `sq`        | The piece's position on the board    |
| `moves`     | The piece's possible moves           |
| `enPassant` | The en passant pawn, if any          |

Output:

```text
(object) array(
   'color' => 'b',
   'id' => 'Q',
   'sq' => 'd5',
   'moves' =>
  array (
    0 => 'd6',
    1 => 'd7',
    2 => 'd8',
    3 => 'd4',
    4 => 'd3',
    5 => 'd2',
    6 => 'c5',
    7 => 'b5',
    8 => 'a5',
    9 => 'e5',
    10 => 'f5',
    11 => 'g5',
    12 => 'h5',
    13 => 'c6',
    14 => 'e6',
    15 => 'c4',
    16 => 'b3',
    17 => 'a2',
    18 => 'e4',
    19 => 'f3',
    20 => 'g2',
  ),
)
```

#### `public function heuristics($balanced = false, $fen = ''): array`

Obtain the game's heuristics.

```php
$heuristics = $game->heuristics(true);

var_export($heuristics);
```

Output:

```text
array (
  0 =>
  array (
    0 => 0.0,
    1 => 0.0,
    2 => -0.25,
    3 => 0.17,
    4 => 0.0,
    5 => 0.0,
    6 => -1.0,
    7 => -1.0,
  ),
  1 =>
  array (
    0 => 0.0,
    1 => -1.0,
    2 => 0.75,
    3 => -0.92,
    4 => -1.0,
    5 => -1.0,
    6 => 0.0,
    7 => 0.0,
  ),
)
```

#### `public function response(): ?string`

Returns a computer response to the current position. This method is to be used in either `Game::MODE_AI` or `Game::MODE_GRANDMASTER` otherwise it returns null.

```php
$game = new Game(Game::MODE_GRANDMASTER);

$game->play('w', 'e4');
$response = $game->response();
echo $response;
```

Output:

```
c6
```

#### `public function state(): object`

Returns the state of the board.

```php
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

#### `public function undoMove(): ?object`

Undoes the last move returning the resulting state.

```php
$state = $game->undoMove();
```
