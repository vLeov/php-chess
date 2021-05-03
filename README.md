## PHP Chess

[![Latest Stable Version](https://poser.pugx.org/programarivm/php-chess/v/stable)](https://packagist.org/packages/programarivm/php-chess)
[![Build Status](https://travis-ci.org/programarivm/php-chess.svg?branch=master)](https://travis-ci.org/programarivm/php-chess)
[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

<p align="center">
	<img src="https://github.com/programarivm/php-chess/blob/master/resources/chess-board.jpg" />
</p>

A chess library for PHP.

### Install

Via composer:

    $ composer require programarivm/php-chess

### Instantiation

Just instantiate a game and play PGN moves:

```php
use Chess\Game;

$game = new Game;

$isLegalMove = $game->play('w', 'e4');
```
The call to the `$game->play` method returns `true` or `false` depending on whether or not a chess move can be run on the board.

### Game methods

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
$game = new Game;

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
$game = new Game;

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
$game = new Game;

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

#### `play()`

Play chess with the AI.

```php
$game = new Game(Game::MODE_PVA);

$game->play('w', 'e4');
$game->play('b', $game->response());
$game->play('w', 'e5');
$game->play('b', $game->response());
```

Currently, a few machine learning models are being built at [programarivm/chess-data](https://github.com/programarivm/chess-data) with the help of [Rubix ML](https://github.com/RubixML/ML). The AIs are stored in the [`model`](https://github.com/programarivm/php-chess/tree/master/model) folder and the default is `a1.model`, however another AI can be used by passing a second parameter to the `Chess\Game` constructor:

```php
$game = new Game(Game::MODE_PVA, 'a2.model');

$game->play('w', 'e4');
$game->play('b', $game->response());
$game->play('w', 'e5');
$game->play('b', $game->response());
```

The supervised learning process is all about using suitable heuristics such as king safety, pressure, material or connectivity, among others. But how can we measure the efficiency of a given chess heuristic? This is where plotting data on nice charts comes to the rescue!

A live demo is available at https://programarivm.github.io/heuristics-quest/.

### Usage

For further details please look at the [tests](https://github.com/programarivm/php-chess/tree/master/tests).

### License

The GNU General Public License.

### Contributions

Would you help make this library better? Contributions are welcome.

- Feel free to send a pull request
- Drop an email at info@programarivm.com with the subject "PHP Chess Contributions"
- Leave me a comment on [Twitter](https://twitter.com/programarivm)

Many thanks.
