The methods in the [`Chess\Ascii`](https://php-chess.readthedocs.io/en/latest/ascii/) class can be used to convert [`Chess\Board`](https://php-chess.readthedocs.io/en/latest/board/) objects into character-based representations such as strings or arrays, and vice versa.

Let's look at the methods available through the following examples.

> For further details please check out the tests in [unit/tests/AsciiTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/AsciiTest.php).

---

Create an ASCII array given a `Chess\Board` object.

```php
use Chess\Ascii;
use Chess\Board;

$board = new Board();
$board->play('w', 'e4');
$board->play('b', 'e5');

$array = Ascii::toArray($board);

print_r($array);
```

Output:

```
Array
(
    [7] => Array
        (
            [0] =>  r
            [1] =>  n
            [2] =>  b
            [3] =>  q
            [4] =>  k
            [5] =>  b
            [6] =>  n
            [7] =>  r
        )

    [6] => Array
        (
            [0] =>  p
            [1] =>  p
            [2] =>  p
            [3] =>  p
            [4] =>  .
            [5] =>  p
            [6] =>  p
            [7] =>  p
        )

    [5] => Array
        (
            [0] =>  .
            [1] =>  .
            [2] =>  .
            [3] =>  .
            [4] =>  .
            [5] =>  .
            [6] =>  .
            [7] =>  .
        )

    [4] => Array
        (
            [0] =>  .
            [1] =>  .
            [2] =>  .
            [3] =>  .
            [4] =>  p
            [5] =>  .
            [6] =>  .
            [7] =>  .
        )

    [3] => Array
        (
            [0] =>  .
            [1] =>  .
            [2] =>  .
            [3] =>  .
            [4] =>  P
            [5] =>  .
            [6] =>  .
            [7] =>  .
        )

    [2] => Array
        (
            [0] =>  .
            [1] =>  .
            [2] =>  .
            [3] =>  .
            [4] =>  .
            [5] =>  .
            [6] =>  .
            [7] =>  .
        )

    [1] => Array
        (
            [0] =>  P
            [1] =>  P
            [2] =>  P
            [3] =>  P
            [4] =>  .
            [5] =>  P
            [6] =>  P
            [7] =>  P
        )

    [0] => Array
        (
            [0] =>  R
            [1] =>  N
            [2] =>  B
            [3] =>  Q
            [4] =>  K
            [5] =>  B
            [6] =>  N
            [7] =>  R
        )

)
```

---

Create a `Chess\Board` object given an ASCII array.

```php
use Chess\Ascii;

$array = [
    7 => [ ' r ', ' n ', ' . ', ' q ', ' k ', ' b ', ' . ', ' r ' ],
    6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' p ', ' . ', ' p ' ],
    5 => [ ' . ', ' . ', ' . ', ' p ', ' . ', ' n ', ' p ', ' . ' ],
    4 => [ ' . ', ' . ', ' p ', ' P ', ' . ', ' . ', ' . ', ' . ' ],
    3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
    2 => [ ' . ', ' . ', ' N ', ' . ', ' . ', ' . ', ' P ', ' . ' ],
    1 => [ ' P ', ' P ', ' . ', ' . ', ' . ', ' P ', ' . ', ' P ' ],
    0 => [ ' R ', ' . ', ' B ', ' Q ', ' . ', ' K ', ' N ', ' R ' ],
];

$castle = [
    'w' => [
        'isCastled' => false,
        'O-O' => false,
        'O-O-O' => false,
    ],
    'b' => [
        'isCastled' => false,
        'O-O' => true,
        'O-O-O' => true,
    ],
];

$board = Ascii::toBoard($array, 'b', $castle);
```

---

Create an ASCII string given a `Chess\Board` object.

```php
use Chess\Ascii;
use Chess\Board;

$board = new Board();
$board->play('w', 'e4');
$board->play('b', 'e5');

$string = Ascii::toString($board);

print_r($string);
```

Output:

```
r  n  b  q  k  b  n  r
p  p  p  p  .  p  p  p
.  .  .  .  .  .  .  .
.  .  .  .  p  .  .  .
.  .  .  .  P  .  .  .
.  .  .  .  .  .  .  .
P  P  P  P  .  P  P  P
R  N  B  Q  K  B  N  R
```

---

Set elements in the given ASCII array and then create a `Chess\Board` object.

```php
use Chess\Ascii;

$array = [
    7 => [ ' r ', ' n ', ' b ', ' q ', ' k ', ' b ', ' n ', ' r ' ],
    6 => [ ' p ', ' p ', ' p ', ' p ', ' . ', ' p ', ' p ', ' p ' ],
    5 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
    4 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ' ],
    3 => [ ' . ', ' . ', ' . ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
    2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
    1 => [ ' P ', ' P ', ' P ', ' P ', ' . ', ' P ', ' P ', ' P ' ],
    0 => [ ' R ', ' N ', ' B ', ' Q ', ' K ', ' B ', ' N ', ' R ' ],
];

$board = Ascii::setArrayElem(' . ', 'g1', $array)
            ->setArrayElem(' N ', 'f3', $array)
            ->toBoard($array, 'b');

$board->play('b', 'Nc6');

$string = Ascii::toString($board);

print_r($string);
```

Output:

```
r  .  b  q  k  b  n  r
p  p  p  p  .  p  p  p
.  .  n  .  .  .  .  .
.  .  .  .  p  .  .  .
.  .  .  .  P  .  .  .
.  .  .  .  .  N  .  .
P  P  P  P  .  P  P  P
R  N  B  Q  K  B  .  R
```
