# Explain PGN

✨ Typically, chess engines won't provide an explanation in easy-to-understand language about why a move is good.

[Chess\Tutor\PgnExplanation](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Tutor/PgnExplanationTest.php) can explain the implications of making a particular move in terms of [chess concepts](https://php-chess.readthedocs.io/en/latest/heuristics/) and combined with an [UCI engine](https://php-chess.readthedocs.io/en/latest/play-computer/) it will explain the why of a good move. Stockfish has been set up with a skill level of `20` and a depth of `15` to suggest a good move. In order to use this functionality, make sure to install Stockfish >= 15.1 as it is described in [Play Computer](https://php-chess.readthedocs.io/en/latest/play-computer/).

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
