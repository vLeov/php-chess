# Explain FEN

✨ Chess beginners often think they can checkmate the opponent's king quickly. However, there are so many different things to consider in order to understand a position.

[Chess\Tutor\FenExplanation](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Tutor/FenExplanationTest.php) helps you improve your chess thinking process by explaining a FEN position in terms of [chess concepts](https://php-chess.readthedocs.io/en/latest/heuristics/) like a tutor would do.

```php
use Chess\Tutor\FenExplanation;

$fen = '8/5k2/4n3/8/8/1BK5/1B6/8 w - - 0 1';

$paragraph = (new FenExplanation($fen))->getParagraph();

$text = implode(' ', $paragraph);

echo $text;
```

```text
White has a significant material advantage. White has a significant control of the center. The white pieces are somewhat better connected. The white player is pressuring a little bit more squares than its opponent. The knight on e6 is pinned so it can't be moved because the king would be put in check. White has the bishop pair.
```

🎉 The resulting text may sound a little robotic but it can be easily rephrased by the AI of your choice to make it sound more human-like.
