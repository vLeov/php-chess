# Heuristics

✨ If you ask a grandmaster why a chess move is considered to be good, they'll probably give you a bunch of reasons intuitively supporting the best decision.

It is important to develop your pieces in the opening while trying to control the board's center at the same time. Castling is an excellent move in an early stage of the game: It helps your king be safer and develop one of your rooks towards the center of the board too.

Then, in the middlegame space becomes an advantage.

And if a complex chess position can be simplified by taking advantage of your opponent's weaknesses, then so much the better — the pawn structure could determine the endgame.

The list of strategies used behind the scenes goes on and on.

The mathematician Claude Shannon came to the conclusion that there are more chess moves than atoms in the universe. The game is complex and you need to learn how to make decisions to play chess like a pro. Since no human can calculate more than, let's say 30 moves ahead, it's all about thinking in terms of heuristics.

Heuristics are quick, mental shortcuts that we humans use to make decisions and solve problems in our daily lives. While far from being perfect, heuristics are helpful approximations that help the brain save energy and manage cognitive load.

Listed below are the chess heuristics implemented in PHP Chess.

| Heuristic | Evaluation |
| ------- | ---------- |
| Absolute fork | [Chess\Eval\AbsoluteForkEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/AbsoluteForkEvalTest.php) |
| Absolute pin | [Chess\Eval\AbsolutePinEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/AbsolutePinEvalTest.php) |
| Attack | [Chess\Eval\AttackEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/AttackEvalTest.php) |
| Backward pawn | [Chess\Eval\BackwardPawnEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/BackwardPawnEvalTest.php) |
| Bad bishop | [Chess\Eval\BadBishopEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/BadBishopEvalTest.php) |
| Bishop outpost | [Chess\Eval\BishopOutpostEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/BishopOutpostEvalTest.php) |
| Bishop pair | [Chess\Eval\BishopPairEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/BishopPairEvalTest.php) |
| Center | [Chess\Eval\CenterEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/CenterEvalTest.php) |
| Connectivity | [Chess\Eval\ConnectivityEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/ConnectivityEvalTest.php) |
| Defense | [Chess\Eval\DefenseEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/DefenseEvalTest.php) |
| Direct opposition | [Chess\Eval\DirectOppositionEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/DirectOppositionEvalTest.php) |
| Doubled pawn | [Chess\Eval\DoubledPawnEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/DoubledPawnEvalTest.php) |
| Isolated pawn | [Chess\Eval\IsolatedPawnEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/IsolatedPawnEvalTest.php) |
| King safety | [Chess\Eval\KingSafetyEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/KingSafetyEvalTest.php) |
| Knight outpost | [Chess\Eval\KnightOutpostEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/KnightOutpostEvalTest.php) |
| Material | [Chess\Eval\MaterialEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/MaterialEvalTest.php) |
| Passed pawn | [Chess\Eval\PassedPawnEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/PassedPawnEvalTest.php) |
| Pressure | [Chess\Eval\PressureEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/PressureEvalTest.php) |
| Relative fork | [Chess\Eval\RelativeForkEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/RelativeForkEvalTest.php) |
| Relative pin | [Chess\Eval\RelativePinEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/RelativePinEvalTest.php) |
| Space | [Chess\Eval\SpaceEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/SpaceEvalTest.php) |
| Square outpost | [Chess\Eval\SqOutpostEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/SqOutpostEvalTest.php) |
| Tactics | [Chess\Eval\TacticsEval](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Eval/TacticsEvalTest.php) |

The evaluation functions are then grouped in two heuristics classes to transform the chess board state into numbers: [Chess\HeuristicsByFenString](https://github.com/chesslablab/php-chess/blob/master/tests/unit/HeuristicsByFenStringTest.php) and [Chess\Heuristics](https://github.com/chesslablab/php-chess/blob/master/tests/unit/HeuristicsTest.php). The former allows to take a so-called heuristic picture of a particular chess position while the latter enables to take a picture of an entire game.

![Figure 1](https://raw.githubusercontent.com/chesslablab/website/master/public/assets/img/heuristics_bar.png)

Figure 1. Heuristics of `rnbqkb1r/p1pp1ppp/1p2pn2/8/2PP4/2N2N2/PP2PPPP/R1BQKB1R b KQkq -`

![Figure 2](https://raw.githubusercontent.com/chesslablab/website/master/public/assets/img/heuristics.png)

Figure 2. Heuristics of `1.d4 Nf6 2.c4 e6 3.Nf3 b6 4.Nc3`

A chess game can be plotted in terms of balance. +1 is the best possible evaluation for White and -1 the best possible evaluation for Black. Both forces being set to 0 means they're balanced.
