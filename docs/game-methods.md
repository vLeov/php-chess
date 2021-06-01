#### `isCheck()`

Finds out if the game is in check.

```php
$isCheck = $game->isCheck();
```

#### `isMate()`

Finds out if the game is over.

```php
$isMate = $game->isMate();
```

#### `status()`

Gets the current game's status.

```php
$status = $game->status();
```

`$status` is a PHP object containing useful information about the game being played.

| Property       | Description                                |
|----------------|--------------------------------------------|
| `turn`         | The current player's turn                  |
| `squares`      | Free/used squares on the board             |
| `pressure`       | Squares being pressured by both players     |
| `space`        | Squares being controlled by both players   |
| `castling`     | The castling status of the two kings       |

The following sequence of moves:

```php
$game = new Game();

$game->play('w', 'd4');
$game->play('b', 'c6');
$game->play('w', 'Bf4');
$game->play('b', 'd5');
$game->play('w', 'Nc3');
$game->play('b', 'Nf6');
$game->play('w', 'Bxb8');
$game->play('b', 'Rxb8');

$status = $game->status();
```

Will generate a `$status` object which properties are accessed this way:

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

#### `piece()`

Gets a piece by its position on the board.

    $piece = $game->piece('c8');

`$piece` is a PHP object containing information about the chess piece selected:

| Property       | Description                                |
|----------------|--------------------------------------------|
| `color`        | The piece's color in PGN format            |
| `identity`     | The piece's identity in PGN format         |
| `position`     | The piece's position on the board          |
| `moves`        | The piece's possible moves                 |

The following code:

```php
$game = new Game();

$piece = $game->piece('b8');
```

Will generate a `$piece` object which properties are accessed this way:

```php
$piece->color;
$piece->identity;
$piece->position;
$piece->moves;
```

#### `pieces()`

Gets the pieces on the board by color.

    $blackPieces = $game->pieces('b');

`$blackPieces` is an array of PHP objects containing information about black pieces.

| Property       | Description                                |
|----------------|--------------------------------------------|
| `identity`     | The piece's identity in PGN format         |
| `position`     | The piece's position on the board          |
| `moves`        | The piece's possible moves                 |

The following code:

```php
$game = new Game();

$blackPieces = $game->pieces('b');
```

Will generate a `$blackPieces` array of objects which properties are accessed this way:

```php
$blackPieces[1]->identity;
$blackPieces[1]->position;
$blackPieces[1]->moves;
```
#### `history()`

Gets the game's history in the form of an array of `stdClass` objects.

```php
$history = $game->history();
```

#### `movetext()`

Gets the game's movetext in text format.

```php
$movetext = $game->movetext();
```

#### `captures()`

Gets the pieces captured by both players as an array of `stdClass` objects.

```php
$captures = $game->captures();
```

#### `events()`

Gets the events taking place: threatened piece, pawn promotion, and so on.

```php
$events = $game->events();
```
