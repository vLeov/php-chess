## PHP Chess

[![Latest Stable Version](https://poser.pugx.org/chesslablab/php-chess/v/stable)](https://packagist.org/packages/chesslablab/php-chess)
![GitHub Workflow Status](https://github.com/chesslablab/php-chess/actions/workflows/php.yml/badge.svg)
[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![Downloads](https://img.shields.io/packagist/dt/chesslablab/php-chess.svg)]((https://packagist.org/packages/chesslablab/php-chess))

A chess library for PHP.

### Install

Via composer:

    $ composer require chesslablab/php-chess

### Play Chess

Variants:

- `Chess\Game::VARIANT_960`
- `Chess\Game::VARIANT_CAPABLANCA_80`
- `Chess\Game::VARIANT_CAPABLANCA_100`
- `Chess\Game::VARIANT_CLASSICAL`

Modes:

- `Chess\Game::MODE_ANALYSIS`
- `Chess\Game::MODE_GM`
- `Chess\Game::MODE_FEN`
- `Chess\Game::MODE_PGN`
- `Chess\Game::MODE_PLAY`
- `Chess\Game::MODE_STOCKFISH`

```php
use Chess\Game;

$game = new Game(
    Game::VARIANT_CLASSICAL,
    Game::MODE_ANALYSIS
);

$game->play('w', 'e4');
$game->play('b', 'e5');
```

The call to the `$game->play` method returns `true` or `false` depending on whether or not a move can be made in Portable Game Notation (PGN) format. The Universal Chess Interface (UCI) protocol is supported as well as the long algebraic notation.

```php
$game->playLan('w', 'e2e4');
$game->playLan('b', 'e7e5');
```

### Documentation

Read the latest docs [here](https://php-chess.readthedocs.io/en/latest/).

### Demo

Check out [this demo](https://www.chesslablab.com).

### License

The GNU General Public License.

### Contributions

See the [contributing guidelines](https://github.com/chesslablab/php-chess/blob/master/CONTRIBUTING.md).

Happy learning and coding! Thank you, and keep it up.
