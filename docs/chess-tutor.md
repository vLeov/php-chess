# Chess Tutor

## Explain FEN

✨ Chess beginners often think they can checkmate the opponent's king quickly. However, there are so many different things to consider in order to understand a position.

[Chess\Tutor\FenExplanation](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Tutor/FenExplanationTest.php) helps you improve your chess thinking process by explaining a FEN position in terms of [chess concepts](https://php-chess.docs.chesslablab.org/heuristics/).

```php
use Chess\FenToBoard;
use Chess\Tutor\FenExplanation;

$board = FenToBoard::create('8/5k2/4n3/8/8/1BK5/1B6/8 w - - 0 1');

$paragraph = (new FenExplanation($board))->getParagraph();

$text = implode(' ', $paragraph);

echo $text;
```

```text
White has a significant material advantage. White has a significant control of the center. The white pieces are somewhat better connected. The white player is pressuring a little bit more squares than its opponent. The knight on e6 is pinned so it can't be moved because the king would be put in check. White has the bishop pair.
```

The resulting text may sound a little robotic but it can be easily rephrased by the AI of your choice to make it sound more human-like. Also a quick numerical estimate of the position can be obtained by passing the `$isEvaluated` parameter to the constructor.

```php
use Chess\FenToBoard;
use Chess\Tutor\FenExplanation;

$board = FenToBoard::create('rnb1kbnr/ppppqppp/8/4p3/4PP2/6P1/PPPP3P/RNBQKBNR w KQkq -');

$paragraph = (new FenExplanation($board, $isEvaluated = true))->getParagraph();

$text = implode(' ', $paragraph);

echo $text;
```

```text
Black has a somewhat better control of the center. The black pieces are significantly better connected. White has a kind of space advantage. Overall, 1 heuristic evaluation feature is favoring White while 2 are favoring Black.
```

A heuristic evaluation is a quick numerical estimate of a chess position that suggests who may be better without considering checkmate. Please note that a heuristic evaluation is not the same thing as a chess calculation. Heuristic evaluations are often correct but may fail as long as they are based on probabilities more than anything else.

🎉 This is a form of abductive reasoning.

## Explain PGN

✨ Typically, chess engines won't provide an explanation in easy-to-understand language about why a move is good.

[Chess\Tutor\PgnExplanation](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Tutor/PgnExplanationTest.php) can explain the implications of making a particular move in terms of [chess concepts](https://php-chess.docs.chesslablab.org/heuristics/) and combined with an UCI engine it will explain the why of a good move. Stockfish has been set up with a skill level of `20` and a depth of `15` to suggest a good move. In order to use this functionality, make sure to install Stockfish >= 15.1 as it is described in [Play Computer](https://php-chess.docs.chesslablab.org/play-computer/).

```php
use Chess\Play\SanPlay;
use Chess\Tutor\PgnExplanation;

$movetext = '1.Nf3 d5 2.g3 c5';

$board = (new SanPlay($movetext))->validate()->getBoard();

$paragraph = (new PgnExplanation('d4', $board->toFen()))->getParagraph();

$text = implode(' ', $paragraph);

echo $text;
```

```text
Black has a kind of space advantage. The pawn on c5 is unprotected.
```

The resulting text may sound a little robotic but it can be easily rephrased by the AI of your choice to make it sound more human-like. Also a quick numerical estimate of the position can be obtained by passing the `$isEvaluated` parameter to the constructor.

```php
use Chess\Tutor\PgnExplanation;

$paragraph = (new PgnExplanation('Bxe6+', '8/5k2/4n3/8/8/1BK5/1B6/8 w - - 0 1', $isEvaluated = true))
    ->getParagraph();

$text = implode(' ', $paragraph);

echo $text;
```

```text
White has a decisive material advantage. White is just controlling the center. White has a total space advantage. The white pieces are timidly approaching the other side's king. The bishop on e6 is unprotected. Overall, 6 heuristic evaluation features are favoring White while 1 is favoring Black.
```

🎉 Let's do this!
