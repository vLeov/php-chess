# Home

PHP Chess is a library implemented in PHP that allows to create chess apps out-of-the-box.

One key feature is that it has been designed with OOP principles in mind and is thoroughly tested with plenty of unit tests. The unit tests are the best documentation. They contain hundreds of real examples on how to use the PHP Chess API.

Almost every class in the [src](https://github.com/chesslablab/php-chess/tree/master/src) folder represents a concept that is tested accordingly in the [tests/unit](https://github.com/chesslablab/php-chess/tree/master/tests/unit) folder, in other words, the structure of the [tests/unit](https://github.com/chesslablab/php-chess/tree/master/tests/unit) folder is mirroring the structure of the [src](https://github.com/chesslablab/php-chess/tree/master/src) folder. For further details on how to use a particular class, please feel free to browse the codebase and check out the corresponding tests.

The PHP Chess docs are more of a tutorial rather than an API description.

## Features

### Object-Oriented API

Data processing with an object-oriented API. The chess board representation is an object of type [SplObjectStorage](https://www.php.net/manual/en/class.splobjectstorage.php) as opposed to a bitboard.

### Thoroughly Tested

PHP Chess has been developed with a test-driven development (TDD) approach. The [tests/unit](https://github.com/chesslablab/php-chess/tree/master/tests/unit) folder contains plenty of real examples.

### Easy to Learn

Almost everything in PHP Chess can be done with a chessboard object. There are three different variants supported with the default one being classical chess.

| Variant | Chessboard |
| ------- | ---------- |
| Capablanca | [Chess\Variant\Capablanca\Board](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Variant/Capablanca/BoardTest.php) |
| Chess960 | [Chess\Variant\Chess960\Board](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Variant/Chess960/BoardTest.php) |
| Classical | [Chess\Variant\Classical\Board](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Variant/Classical/BoardTest.php) |

### Lightweight

Requires two PHP dependencies: Rubix ML for machine learning and Imagine for image processing.
