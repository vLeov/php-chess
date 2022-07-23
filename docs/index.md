## PHP Chess

[![Latest Stable Version](https://poser.pugx.org/chesslablab/php-chess/v/stable)](https://packagist.org/packages/chesslablab/php-chess)
![GitHub Workflow Status](https://github.com/chesslablab/php-chess/actions/workflows/php.yml/badge.svg)
[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

A chess library for PHP.

### Install

Via composer:

    $ composer require chesslablab/php-chess

### Play Chess

```php
use Chess\Game;

$game = new Game();

$game->play('w', 'e4');
$game->play('b', 'e5');
```
The call to the `$game->play` method returns `true` or `false` depending on whether or not a chess move can be made.

### Documentation

Read the latest docs [here](https://php-chess.readthedocs.io/en/latest/).

### Demo

Check out [this demo](https://www.chesslablab.com).

### License

The GNU General Public License.

### Contributions

See the [contributing guidelines](https://github.com/chesslablab/php-chess/blob/master/CONTRIBUTING.md).

Happy learning and coding! Thank you, and keep it up.
