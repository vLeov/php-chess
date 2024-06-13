# Chess Tutor

## Explain a FEN Position

✨ Chess beginners often think they can checkmate the opponent's king quickly. However, there are so many different things to consider in order to understand a position.

[Chess\Tutor\FenEvaluation](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Tutor/FenEvaluationTest.php) helps you improve your chess thinking process by evaluating a FEN position in terms of [chess concepts](https://chesslablab.github.io/php-chess/heuristics/) like in the example below.

```php
use Chess\FenToBoardFactory;
use Chess\Tutor\FenEvaluation;

$board = FenToBoardFactory::create('8/5k2/4n3/8/8/1BK5/1B6/8 w - - 0 1');

$paragraph = (new FenEvaluation($board))->getParagraph();

$text = implode(' ', $paragraph);

echo $text;
```

```text
White has a decisive material advantage. White has a slightly better control of the center. The white pieces are significantly better connected. The white player is pressuring a little bit more squares than its opponent. White has a slight absolute pin advantage. White has the bishop pair. The knight on e6 is pinned shielding the king so it cannot move out of the line of attack because the king would be put in check. Overall, 6 heuristic evaluation features are favoring White while 0 are favoring Black.
```

A heuristic evaluation is a quick numerical estimate of a chess position that suggests who may be better without considering checkmate. Please note that a heuristic evaluation is not the same thing as a chess calculation. Heuristic evaluations are often correct but may fail as long as they are based on probabilities more than anything else.

🎉 This is a form of abductive reasoning.

## Explain a PGN Move

✨ Typically, chess engines won't provide an explanation in easy-to-understand language about how a move changes the position on the board.

[Chess\Tutor\PgnEvaluation](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Tutor/PgnEvaluationTest.php) explains how a particular move changes the position.

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
Black has a slight space advantage. White has a slight protection advantage. White has a slight attack advantage. The pawn on c5 is unprotected. The c5-square is under threat of being attacked. Overall, 3 heuristic evaluation features are favoring White while 2 are favoring Black.
```

The resulting text may sound a little robotic but it can be easily rephrased by the AI of your choice to make it sound more human-like.

## Explain a Good PGN Move

✨ It's often difficult for beginners to understand why a move is good.

With the help of an UCI engine [Chess\Tutor\GoodPgnEvaluation](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Tutor/GoodPgnEvaluationTest.php) can explain the why of a good move.

```php
use Chess\Play\SanPlay;
use Chess\Tutor\GoodPgnEvaluation;
use Chess\UciEngine\UciEngine;
use Chess\UciEngine\Details\Limit;

$movetext = '1.d4 d5 2.c4 Nc6 3.cxd5 Qxd5 4.e3 e5 5.Nc3 Bb4 6.Bd2 Bxc3 7.Bxc3 exd4 8.Ne2';

$limit = (new Limit())->setDepth(12);
$stockfish = new UciEngine('/usr/games/stockfish');
$board = (new SanPlay($movetext))->validate()->getBoard();

$goodPgnEvaluation = new GoodPgnEvaluation($limit, $stockfish, $board);

$pgn = $goodPgnEvaluation->getPgn();
$paragraph = implode(' ', $goodPgnEvaluation->getParagraph());

echo $pgn . PHP_EOL;
echo $paragraph . PHP_EOL;
```

```text
Bg4
The black player is pressuring a little bit more squares than its opponent. The black pieces are timidly approaching the other side's king. Black has a total relative pin advantage. The knight on e2 is pinned shielding a piece that is more valuable than the attacking piece. Overall, 4 heuristic evaluation features are favoring White while 8 are favoring Black.
```

🎉 Let's do this!
