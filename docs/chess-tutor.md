# Chess Tutor

## Explain FEN

✨ Chess beginners often think they can checkmate the opponent's king quickly. However, there are so many different things to consider in order to understand a position.

[Chess\Tutor\FenEvaluation](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Tutor/FenEvaluationTest.php) helps you improve your chess thinking process by evaluating a FEN position in terms of [chess concepts](https://php-chess.docs.chesslablab.org/heuristics/).

```php
use Chess\FenToBoardFactory;
use Chess\Tutor\FenEvaluation;

$board = FenToBoardFactory::create('8/5k2/4n3/8/8/1BK5/1B6/8 w - - 0 1');

$paragraph = (new FenEvaluation($board))->getParagraph();

$text = implode(' ', $paragraph);

echo $text;
```

```text
White has a significant material advantage. White has a significant control of the center. The white pieces are somewhat better connected. The white player is pressuring a little bit more squares than its opponent. White has some absolute pin advantage. White has the bishop pair. The knight on e6 is pinned shielding the king so it cannot move out of the line of attack because the king would be put in check. Overall, 6 heuristic evaluation features are favoring White while 0 are favoring Black.
```

A heuristic evaluation is a quick numerical estimate of a chess position that suggests who may be better without considering checkmate. Please note that a heuristic evaluation is not the same thing as a chess calculation. Heuristic evaluations are often correct but may fail as long as they are based on probabilities more than anything else.

🎉 This is a form of abductive reasoning.

## Explain PGN

✨ Typically, chess engines won't provide an explanation in easy-to-understand language about why a move is good.

[Chess\Tutor\PgnEvaluation](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Tutor/PgnEvaluationTest.php) can explain the implications of making a particular move in terms of [chess concepts](https://php-chess.docs.chesslablab.org/heuristics/) and combined with an UCI engine it will explain the why of a good move. Stockfish has been set up with a skill level of `20` and a depth of `15` to suggest a good move. In order to use this functionality, make sure to install Stockfish >= 15.1 as it is described in [Play Computer](https://php-chess.docs.chesslablab.org/play-computer/).

```php
use Chess\Play\SanPlay;
use Chess\Tutor\PgnEvaluation;

$movetext = '1.Nf3 d5 2.g3 c5';

$board = (new SanPlay($movetext))->validate()->getBoard();

$paragraph = (new PgnEvaluation('d4', $board))->getParagraph();

$text = implode(' ', $paragraph);

echo $text;
```

```text
Black has some space advantage. White has a small protection advantage. The pawn on c5 is unprotected. Overall, 2 heuristic evaluation features are favoring White while 2 are favoring Black.
```

The resulting text may sound a little robotic but it can be easily rephrased by the AI of your choice to make it sound more human-like.

🎉 Let's do this!
