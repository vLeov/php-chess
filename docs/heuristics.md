# Heuristics

✨ If you ask a chess pro why a chess move is good, they'll probably give you a bunch of reasons, many of them intuitive, about why they made that decision.

It is important to develop your pieces in the opening while trying to control the center of the board at the same time. Castling is an excellent move as long as the king gets safe. Then, in the middlegame space becomes an advantage. And if a complex position can be simplified when you have an advantage, then so much the better. The pawn structure could determine the endgame.

The list of reasons goes on and on.

The mathematician Claude Shannon came to the conclusion that there are more chess moves than atoms in the universe. The game is complex and you need to learn how to make decisions to play chess like a pro. Since no human can calculate more than, let's say 30 moves ahead, it's all about thinking in terms of heuristics.

Heuristics are quick, mental shortcuts that we humans use to make decisions and solve problems in our daily lives. While far from being perfect, heuristics are approximations that help manage cognitive load.

Listed below are the chess heuristics implemented in PHP Chess.

| Heuristic | Evaluation |
| ------- | ---------- |
| Absolute fork | [Chess\Eval\AbsoluteForkEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/AbsoluteForkEvalTest.php) |
| Absolute pin | [Chess\Eval\AbsolutePinEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/AbsolutePinEvalTest.php) |
| Absolute skewer | [Chess\Eval\AbsoluteSkewerEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/AbsoluteSkewerEvalTest.php) |
| Advanced pawn | [Chess\Eval\AdvancedPawnEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/AdvancedPawnEvalTest.php) |
| Attack | [Chess\Eval\AttackEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/AttackEvalTest.php) |
| Backward pawn | [Chess\Eval\BackwardPawnEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/BackwardPawnEvalTest.php) |
| Bad bishop | [Chess\Eval\BadBishopEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/BadBishopEvalTest.php) |
| Bishop outpost | [Chess\Eval\BishopOutpostEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/BishopOutpostEvalTest.php) |
| Bishop pair | [Chess\Eval\BishopPairEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/BishopPairEvalTest.php) |
| Center | [Chess\Eval\CenterEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/CenterEvalTest.php) |
| Connectivity | [Chess\Eval\ConnectivityEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/ConnectivityEvalTest.php) |
| Defense | [Chess\Eval\DefenseEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/DefenseEvalTest.php) |
| Diagonal opposition | [Chess\Eval\DiagonalOppositionEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/DiagonalOppositionEvalTest.php) |
| Direct opposition | [Chess\Eval\DirectOppositionEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/DirectOppositionEvalTest.php) |
| Doubled pawn | [Chess\Eval\DoubledPawnEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/DoubledPawnEvalTest.php) |
| Far-advanced pawn | [Chess\Eval\FarAdvancedPawnEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/FarAdvancedPawnEvalTest.php) |
| Isolated pawn | [Chess\Eval\IsolatedPawnEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/IsolatedPawnEvalTest.php) |
| King safety | [Chess\Eval\KingSafetyEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/KingSafetyEvalTest.php) |
| Knight outpost | [Chess\Eval\KnightOutpostEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/KnightOutpostEvalTest.php) |
| Material | [Chess\Eval\MaterialEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/MaterialEvalTest.php) |
| Passed pawn | [Chess\Eval\PassedPawnEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/PassedPawnEvalTest.php) |
| Pressure | [Chess\Eval\PressureEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/PressureEvalTest.php) |
| Protection | [Chess\Eval\ProtectionEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/ProtectionEvalTest.php) |
| Relative fork | [Chess\Eval\RelativeForkEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/RelativeForkEvalTest.php) |
| Relative pin | [Chess\Eval\RelativePinEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/RelativePinEvalTest.php) |
| Space | [Chess\Eval\SpaceEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/SpaceEvalTest.php) |
| Square outpost | [Chess\Eval\SqOutpostEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/SqOutpostEvalTest.php) |
| Threat | [Chess\Eval\ThreatEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/ThreatEvalTest.php) |

The evaluation features are used in two heuristics classes: [Chess\Heuristics\FenHeuristics](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Heuristics/FenHeuristicsTest.php) and [Chess\Heuristics\SanHeuristics](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Heuristics/SanHeuristicsTest.php). The former allows to transform a FEN position to numbers while the latter transforms an entire chess game in SAN format to numbers.

```php
use Chess\Function\StandardFunction;
use Chess\Heuristics\FenHeuristics;

$fen = 'rnbqkb1r/p1pp1ppp/1p2pn2/8/2PP4/2N2N2/PP2PPPP/R1BQKB1R b KQkq -';

$result = [
    'names' => (new StandardFunction())->names(),
    'balance' => (new FenHeuristics($fen))->getBalance(),
];

print_r($result);
```

```text
Array
(
    [names] => Array
        (
            [0] => Material
            [1] => Center
            [2] => Connectivity
            [3] => Space
            [4] => Pressure
            [5] => King safety
            [6] => Protection
            [7] => Threat
            [8] => Attack
            [9] => Doubled pawn
            [10] => Passed pawn
            [11] => Advanced pawn
            [12] => Far-advanced pawn
            [13] => Isolated pawn
            [14] => Backward pawn
            [15] => Defense
            [16] => Absolute skewer
            [17] => Absolute pin
            [18] => Relative pin
            [19] => Absolute fork
            [20] => Relative fork
            [21] => Outpost square
            [22] => Knight outpost
            [23] => Bishop outpost
            [24] => Bishop pair
            [25] => Bad bishop
            [26] => Diagonal opposition
            [27] => Direct opposition
        )

    [balance] => Array
        (
            [0] => 0
            [1] => 12.4
            [2] => 0
            [3] => 3
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
            [19] => 0
            [20] => 0
            [21] => 0
            [22] => 0
            [23] => 0
            [24] => 0
            [25] => 0
            [26] => 0
            [27] => 0
        )

)
```

A chess game can be plotted in terms of balance. +1 is the best possible evaluation for White and -1 the best possible evaluation for Black. Both forces being set to 0 means they're balanced.

```php
use Chess\Function\StandardFunction;
use Chess\Heuristics\SanHeuristics;

$movetext = '1.d4 Nf6 2.c4 e6 3.Nf3 b6 4.Nc3';

$result = [
    'names' => (new StandardFunction())->names(),
    'balance' => (new SanHeuristics($movetext))->getBalance(),
];

print_r($result);
```

![Figure 1](https://raw.githubusercontent.com/chesslablab/php-chess/master/docs/heuristics_01.png)

Figure 1. Heuristics of `1.d4 Nf6 2.c4 e6 3.Nf3 b6 4.Nc3`

🎉 There it is! Chess positions converted to numbers can be processed with machine learning techniques.
