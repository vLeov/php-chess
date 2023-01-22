`Chess\Movetext` provides with functionality to parse and process a PGN movetext. Let's look at the methods available through some examples. For further information you may want to check out the tests in [tests/unit/MovetextTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/MovetextTest.php).

---

#### `public function validate(): string`

Validates a movetext returning a string if valid; otherwise  throws a `Chess\Exception\MovetextException`.

```php
use Chess\Variant\Classical\PGN\Move;
use Chess\Movetext;

$move = new Move();
$text = '1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5';

$movetext = (new Movetext($move, $text))->validate();

print_r($movetext);
```
```text
1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5
```

#### `public function sequence(): array`

Returns an array representing the movetext as a sequence of moves.

```php
use Chess\Variant\Classical\PGN\Move;
use Chess\Movetext;

$move = new Move();
$text = '1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5';

$sequence = (new Movetext($move, $text))->sequence();

print_r($sequence);
```
```
Array
(
    [0] => 1.d4 Nf6
    [1] => 1.d4 Nf6 2.Nf3 e6
    [2] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+
    [3] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O
    [4] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7
    [5] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6
    [6] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5
)
```
