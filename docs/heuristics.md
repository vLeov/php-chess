A [`Chess\Game`](https://php-chess.readthedocs.io/en/latest/game/) object can be thought of in terms of snapshots describing what's going on its [`Chess\Board`](https://php-chess.readthedocs.io/en/latest/board/) as reported by a number of evaluation features, thus, PGN movetexts can be evaluated by considering those.

Let's look at the `Chess\Heuristics` methods available through the following example:

```php
use Chess\Game;
use Chess\Heuristics;

$game = new Game();

$game->play('w', 'e4');
$game->play('b', 'e6');
$game->play('w', 'd4');
$game->play('b', 'd5');

$movetext = $game->getBoard()->getMovetext();
```

For further information you may want to check out the tests in [tests/unit/HeuristicsTest.php](https://github.com/chesslablab/php-chess/blob/master/tests/unit/HeuristicsTest.php).

---

#### `public function getDims(): array`

Returns the evaluation features also known as dimensions.

```php
$dims = (new Heuristics())->getDims();

print_r($dims);
```
```text
Array
(
    [Chess\Eval\MaterialEval] => 28
    [Chess\Eval\CenterEval] => 4
    [Chess\Eval\ConnectivityEval] => 4
    [Chess\Eval\SpaceEval] => 4
    [Chess\Eval\PressureEval] => 4
    [Chess\Eval\KingSafetyEval] => 4
    [Chess\Eval\TacticsEval] => 4
    [Chess\Eval\AttackEval] => 4
    [Chess\Eval\DoubledPawnEval] => 4
    [Chess\Eval\PassedPawnEval] => 4
    [Chess\Eval\IsolatedPawnEval] => 4
    [Chess\Eval\BackwardPawnEval] => 4
    [Chess\Eval\AbsolutePinEval] => 4
    [Chess\Eval\RelativePinEval] => 4
    [Chess\Eval\AbsoluteForkEval] => 4
    [Chess\Eval\RelativeForkEval] => 4
    [Chess\Eval\SqOutpostEval] => 4
    [Chess\Eval\KnightOutpostEval] => 4
    [Chess\Eval\BishopOutpostEval] => 4
)
```

The sum of the weights equals to 100 as per a multiple-criteria decision analysis (MCDA) based on the point allocation method. This allows to label input vectors for further machine learning purposes. The order in which the different chess evaluation features are arranged as a dimension doesn't really matter. The first permutation e.g. [ 15, 15, 15, 10, 5, 5, 5, 5, 5, 5, 5, 5, 5 ] is used to somehow highlight that a particular dimension is a restricted permutation actually.

Let the grandmasters label the chess positions. Once a particular position is successfully transformed into an input vector of numbers, then it can be labeled on the assumption that the best possible move that could be made was made — by a chess grandmaster.

#### `public function getResult(): array`

Returns the heuristics.

```php
$result = (new Heuristics($movetext))->getResult();

print_r($result);
```
```text
Array
(
    [w] => Array
        (
            [0] => Array
                (
                    [0] => 0
                    [1] => 0.27
                    [2] => 0.6
                    [3] => 0.17
                    [4] => 0
                    [5] => 0
                    [6] => 0
                    [7] => 0
                    [8] => 0
                    [9] => 0
                    [10] => 0
                    [11] => 0
                    [12] => 0
                    [13] => 0
                    [14] => 0
                    [15] => 0
                    [16] => 0
                    [17] => 0
                    [18] => 0
                )

            [1] => Array
                (
                    [0] => 0
                    [1] => 1
                    [2] => 0
                    [3] => 1
                    [4] => 1
                    [5] => 0
                    [6] => 0
                    [7] => 0
                    [8] => 0
                    [9] => 0
                    [10] => 0
                    [11] => 1
                    [12] => 0
                    [13] => 0
                    [14] => 0
                    [15] => 0
                    [16] => 0
                    [17] => 0
                    [18] => 0
                )

        )

    [b] => Array
        (
            [0] => Array
                (
                    [0] => 0
                    [1] => 0
                    [2] => 1
                    [3] => 0
                    [4] => 0
                    [5] => 0
                    [6] => 0
                    [7] => 0
                    [8] => 0
                    [9] => 0
                    [10] => 0
                    [11] => 0
                    [12] => 0
                    [13] => 0
                    [14] => 0
                    [15] => 0
                    [16] => 0
                    [17] => 0
                    [18] => 0
                )

            [1] => Array
                (
                    [0] => 0
                    [1] => 0.18
                    [2] => 0.6
                    [3] => 0.17
                    [4] => 1
                    [5] => 0
                    [6] => 1
                    [7] => 0
                    [8] => 0
                    [9] => 0
                    [10] => 0
                    [11] => 0
                    [12] => 0
                    [13] => 0
                    [14] => 0
                    [15] => 0
                    [16] => 0
                    [17] => 0
                    [18] => 0
                )

        )

)
```

#### `public function getBalance(): array`

Returns the balanced heuristics. A chess game can be plotted in terms of balance. +1 is the best possible evaluation for White and -1 the best possible evaluation for Black. Both forces being set to 0 means they're actually offset and, therefore, balanced.

```php
$balance = (new Heuristics($movetext))->getBalance();

print_r($balance);
```
```text
Array
(
    [0] => Array
        (
            [0] => 0
            [1] => 0.27
            [2] => -0.4
            [3] => 0.17
            [4] => 0
            [5] => 0
            [6] => 0
            [7] => 0
            [8] => 0
            [9] => 0
            [10] => 0
            [11] => 0
            [12] => 0
            [13] => 0
            [14] => 0
            [15] => 0
            [16] => 0
            [17] => 0
            [18] => 0
        )

    [1] => Array
        (
            [0] => 0
            [1] => 0.82
            [2] => -0.6
            [3] => 0.83
            [4] => 0
            [5] => 0
            [6] => -1
            [7] => 0
            [8] => 0
            [9] => 0
            [10] => 0
            [11] => 1
            [12] => 0
            [13] => 0
            [14] => 0
            [15] => 0
            [16] => 0
            [17] => 0
            [18] => 0
        )

)
```

#### `public function eval(): array`

Returns the evaluation of the chess position in a human readable format. The result obtained suggests which player may be better.

```php
$eval = (new Heuristics($movetext))->eval();

print_r($eval);
```

Output:

```text
Array
(
    [w] => 36
    [b] => 18.65
)
```
