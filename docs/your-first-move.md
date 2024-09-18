# Your First Move

✨ Some familiarity with chess terms and concepts is required but if you're new to chess this tutorial will guide you through how to easily create amazing apps with PHP Chess. Happy coding and learning!

The [Chess\Variant\Classical\Board](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Variant/Classical/BoardTest.php) class is the easiest way to get started with PHP Chess.

```php
use Chess\Variant\Classical\Board;

$board = new Board();
```

If you have ever attended a chess tournament, you've probably noticed that each player writes down their move in PGN format on a piece of paper. PGN stands for Portable Game Notation and is a human-readable format that allows chess players to read and write chess games. When it comes to computer chess, though, a more appropriate machine-readable format called Long Algebraic Notation (LAN) is often used instead.

Be that as it may, you're already set up to play classical chess either in PGN or LAN format.

In PGN format:

```php
$board->play('w', 'e4');
```

In LAN format:

```php
$board->playLan('w', 'e2e4');
```

Every time a move is made, the state of the board changes.

```php
var_dump($board->toFen());
```

```text
string(55) "rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3"
```

This is the chess position in Forsyth–Edwards Notation (FEN) format after 1.e4.

🎉 Congrats! 1.e4 is one of the best moves to start with.
