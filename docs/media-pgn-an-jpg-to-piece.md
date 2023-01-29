`Chess\Media\PGN\AN\JpgToPiece` is a chess piece image recognizer. It converts a chess piece image in JPG format into its algebraic notation (AN) counterpart in PGN format. Let's look at the methods available through the following example. For further information please check out the tests in [tests/unit/Media/PGN/AN/JpgToPieceTest.php ](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Media/PGN/AN/JpgToPieceTest.php).

---

#### `public function predict()`

Converts a chess piece image in JPG format into its algebraic notation (AN) counterpart in PGN format.

```php
use Chess\Media\PGN\AN\JpgToPiece;

$filename = 'image.jpg';

$an = (new JpgToPiece($filename))->predict();
```
