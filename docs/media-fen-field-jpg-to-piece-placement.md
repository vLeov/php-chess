`Chess\Media\FEN\Field\JpgToPiecePlacement` is a chessboard image recognizer. It converts a chess position in JPG format into its FEN string (piece placement only) counterpart. Let's look at the methods available in this class through the following example. For further information please check out these [tests](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Media/FEN/Field/JpgToPiecePlacementTest.php).

---

#### `public function predict(): string`

Converts a chess position in JPG format into its FEN string (piece placement only) counterpart.

```php
use Chess\Media\FEN\Field\JpgToPiecePlacement;

$filename = 'image.jpg';

$piecePlacement = (new JpgToPiecePlacement($filename))->predict();
```
