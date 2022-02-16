#### `output(string $filepath)`

Creates an MP4 video from a particular `Chess\Board` object.

```php
use Chess\Board;
use Chess\Media\BoardToMp4;

$board = new Board();
$board->play('w', 'e4');
$board->play('b', 'd5');
$board->play('w', 'exd5');
$board->play('b', 'Qxd5');

$filename = (new BoardToMp4($board, $flip = true))->output();
```

The code snippet above creates the `620a7d61dcf57.mp4` file.
