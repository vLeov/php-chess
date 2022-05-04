`Chess\Game` is the main component of the [PHP Chess Server](https://github.com/chesslablab/chess-server), a wrapper for the [`Chess\Board`](https://php-chess.readthedocs.io/en/latest/board/) especially suited for playing chess online.

Let's look at the methods available through some examples. For further information you may want to check out the tests in [tests/unit/GameTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/GameTest.php).

---

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
