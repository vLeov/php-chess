#### `output(string $filepath)`

Creates a GIF from a particular `Chess\Board` object.

```php
use Chess\Board;
use Chess\Media\BoardToGif;

$board = new Board();
$board->play('w', 'e4');
$board->play('b', 'd5');
$board->play('w', 'exd5');
$board->play('b', 'Qxd5');

$filename = (new BoardToGif($board, $flip = true))->output();
```

The code snippet above creates the `620a7d61dcf57.gif` file.

![Figure 1](https://raw.githubusercontent.com/chesslablab/php-chess/master/tests/data/gif/620a7d61dcf57.gif)
Figure 1. 1.e4 d5 2.exd5 Qxd5
