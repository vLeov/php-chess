Let's look at a `Chess\Game` through the following example:

```php
use Chess\Game;

$game = new Game();

$game->play('w', 'e4');
$game->play('b', 'd5');
$game->play('w', 'exd5');
$game->play('b', 'Qxd5');
```

#### `ascii(): string`

Prints the ASCII representation of the game.

```php
echo $game->ascii();
```

Output:

```text
 r  n  b  .  k  b  n  r
 p  p  p  .  p  p  p  p
 .  .  .  .  .  .  .  .
 .  .  .  q  .  .  .  .
 .  .  .  .  .  .  .  .
 .  .  .  .  .  .  .  .
 P  P  P  P  .  P  P  P
 R  N  B  Q  K  B  N  R
```

#### `captures(): array`

Gets the pieces captured by both players as an array of `stdClass` objects.

```php
$captures = $game->captures();

print_r($captures);
```

Output:

```text
array (
  'w' =>
  array (
    0 =>
    (object) array(
       'capturing' =>
      (object) array(
         'identity' => 'P',
         'position' => 'e4',
      ),
       'captured' =>
      (object) array(
         'identity' => 'P',
         'position' => 'd5',
      ),
    ),
  ),
  'b' =>
  array (
    0 =>
    (object) array(
       'capturing' =>
      (object) array(
         'identity' => 'Q',
         'position' => 'd8',
      ),
       'captured' =>
      (object) array(
         'identity' => 'P',
         'position' => 'd5',
      ),
    ),
  ),
)
```

#### `events(): stdClass`

Gets the events taking place on the game.

```php
$events = $game->events();

var_export($events);
```

```text
(object) array(
   'w' =>
  array (
    'Check!' => 0,
    'A piece was captured' => 0,
    'A major piece is now threatened by a pawn' => 0,
    'A minor piece is now threatened by a pawn' => 0,
    'A pawn was promoted' => 0,
  ),
   'b' =>
  array (
    'Check!' => 0,
    'A piece was captured' => 1,
    'A major piece is now threatened by a pawn' => 0,
    'A minor piece is now threatened by a pawn' => 0,
    'A pawn was promoted' => 0,
  ),
)
```

#### `fen(): string`

Prints the FEN string representation of the game.

```php
echo $game->fen();
```

Output:

```text
rnb1kbnr/ppp1pppp/8/3q4/8/8/PPPP1PPP/RNBQKBNR w KQkq -
```

#### `history(): array`

Gets the game's history as an array of `stdClass` objects.

```php
$history = $game->history();

var_export($history);
```

Output:

```text
array (
  0 =>
  (object) array(
     'pgn' => 'e4',
     'color' => 'w',
     'identity' => 'P',
     'position' => 'e2',
     'isCapture' => false,
     'isCheck' => false,
  ),
  1 =>
  (object) array(
     'pgn' => 'd5',
     'color' => 'b',
     'identity' => 'P',
     'position' => 'd7',
     'isCapture' => false,
     'isCheck' => false,
  ),
  2 =>
  (object) array(
     'pgn' => 'exd5',
     'color' => 'w',
     'identity' => 'P',
     'position' => 'e4',
     'isCapture' => true,
     'isCheck' => false,
  ),
  3 =>
  (object) array(
     'pgn' => 'Qxd5',
     'color' => 'b',
     'identity' => 'Q',
     'position' => 'd8',
     'isCapture' => true,
     'isCheck' => false,
  ),
)
```

#### `isCheck(): bool`

Finds out if the game is in check.

```php
$isCheck = $game->isCheck();

var_export($isCheck);
```

Output:

```text
false
```

#### `isMate(): bool`

Finds out if the game is over.

```php
$isMate = $game->isMate();

var_export($isMate);
```

Output:

```text
false
```

#### `movetext(): string`

Gets the game's movetext in text format.

```php
$movetext = $game->movetext();

var_export($movetext);
```

Output:

```text
'1.e4 d5 2.exd5 Qxd5'
```

#### `piece(string $square): ?stdClass`

Gets a piece by its position on the board.

```php
$piece = $game->piece('d5');

var_export($piece);
```

`$piece` is a PHP object with information about the piece selected.

| Property       | Description                                |
|----------------|--------------------------------------------|
| `color`        | The piece's color in PGN format            |
| `identity`     | The piece's identity in PGN format         |
| `position`     | The piece's position on the board          |
| `moves`        | The piece's possible moves                 |

Output:

```text
(object) array(
   'color' => 'b',
   'identity' => 'Q',
   'position' => 'd5',
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

#### `pieces(string $color): array`

Gets the pieces on the board by color.

```php
$pieces = $game->pieces('b');

var_export($pieces);
```
`$pieces` is an array of PHP objects with black pieces information.

| Property       | Description                                |
|----------------|--------------------------------------------|
| `identity`     | The piece's identity in PGN format         |
| `position`     | The piece's position on the board          |
| `moves`        | The piece's possible moves                 |


Output:

```text
array (
  0 =>
  (object) array(
     'identity' => 'R',
     'position' => 'a8',
     'moves' =>
    array (
    ),
  ),
  1 =>
  (object) array(
     'identity' => 'N',
     'position' => 'b8',
     'moves' =>
    array (
      0 => 'a6',
      1 => 'c6',
      2 => 'd7',
    ),
  ),
  ...
  13 =>
  (object) array(
     'identity' => 'P',
     'position' => 'h7',
     'moves' =>
    array (
      0 => 'h6',
      1 => 'h5',
    ),
  ),
  14 =>
  (object) array(
     'identity' => 'Q',
     'position' => 'd5',
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
  ),
)
```

#### `status(): stdClass`

Gets the current game's status.

```php
$status = $game->status();
```

`$status` is a PHP object with useful information about the game being played.

| Property       | Description                                |
|----------------|--------------------------------------------|
| `turn`         | The current player's turn                  |
| `squares`      | Free/used squares on the board             |
| `pressure`       | Squares being pressured by both players     |
| `space`        | Squares being controlled by both players   |
| `castling`     | The castling status of the two kings       |

The properties of the  `$status` object are accessed this way:

```php
// current turn
$game->status()->turn;

// used/free squares
$game->status()->squares->used;
$game->status()->squares->free;

// squares being pressured by both players
$game->status()->pressure;

// squares being controlled by both players
$game->status()->space;

// castling status of both players
$game->status()->castling;
```
