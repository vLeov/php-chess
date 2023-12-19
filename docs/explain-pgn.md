# Explain PGN

✨ Typically, chess engines don't provide an explanation in easy-to-understand language about why a move is good.

[Chess\Tutor\PgnParagraph](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Tutor/FenParagraphTest.php) can explain the implications of making a particular move in terms of [chess concepts](https://php-chess.readthedocs.io/en/latest/heuristics/) and combined with an [UCI engine](https://php-chess.readthedocs.io/en/latest/play-computer/) it will explain the why of a good move.

```php
use Chess\Play\SanPlay;
use Chess\Tutor\PgnParagraph;

$movetext = '1.Nf3 d5 2.g3 c5';

$board = (new SanPlay($movetext))->validate()->getBoard();

$paragraph = (new PgnParagraph('d4', $board->toFen()))->getParagraph();

$text = implode(' ', $paragraph);

echo $text;
```

```text
Black has a kind of space advantage. The pawn on c5 is unprotected.
```

🎉 The resulting text may sound a little robotic but it can be easily rephrased by the AI of your choice to make it sound more human-like.
