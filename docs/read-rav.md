# Read RAV

✨ RAV stands for Recursive Annotation Variation. This format is especially useful to write and read tutorials about openings, notable games, chess studies and so on.

RAV is an extension of the Standard Algebaric Notation (SAN) format and allows to annotate chess variations. After all, a RAV movetext is still a SAN movetext with support for comments. Comments are enclosed in curly brackets. Variations are enclosed in parentheses which can be nested recursively as many times as required with the trait that the previous move may need to be undone in order to play a certain variation.

The example below describes how to play the Open Sicilian.

> 1.e4 c5 {enters the Sicilian Defense, the most popular and best-scoring response to White's first move.} (2.Nf3 {is played in about 80% of Master-level games after which there are three main options for Black.} (2... Nc6) (2... e6) (2... d6 {is Black's most common move.} 3.d4 {lines are collectively known as the Open Sicilian.} cxd4 4.Nxd4 Nf6 5.Nc3 {allows Black choose between four major variations: the Najdorf, Dragon, Classical and Scheveningen.} (5...a6 {is played in the Najdorf variation.}) (5...g6 {is played in the Dragon variation.}) (5...Nc6 {is played in the Classical variation.}) (5...e6 {is played in the Scheveningen variation.})))

Sicilian Defense. (2023, July 2). In Wikipedia. [https://en.wikipedia.org/wiki/Sicilian_Defence](https://en.wikipedia.org/wiki/Sicilian_Defence)

Then all you need is a RAV reader.

![Figure 1](https://raw.githubusercontent.com/chesslablab/php-chess/master/docs/read-rav_01.png)
Figure 1. The response received from PHP Chess can be displayed as an HTML table.

The RAV reader shown in Figure 1 displays the variation levels in different shades of gray. It is a 2D scrollable HTML table where the main line is shown in a white background color. The deeper the level, the darker the background color is displayed.

Similarly as with Chess\Play\SanPlay and Chess\Play\LanPlay, [Chess\Play\RavPlay](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Play/RavPlayTest.php) allows to play a RAV movetext. The most important method in this class is the `getFen()` method. This method retrieves the FEN history of a RAV movetext to be displayed for reading purposes as shown in Figure 1.

```php
use Chess\Play\RavPlay;

$movetext = "1.e4 c5
    (2.Nf3 (2... Nc6) (2... e6)
        (2... d6 3.d4 cxd4 4.Nxd4 Nf6 5.Nc3
            (5...a6)
            (5...g6)
            (5...Nc6)
            (5...e6)
        )
    )";

$ravPlay = (new RavPlay($movetext))->validate();

$fen = $ravPlay->getFen();

print_r($fen);
```

```text
Array
(
    [0] => rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq -
    [1] => rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3
    [2] => rnbqkbnr/pp1ppppp/8/2p5/4P3/8/PPPP1PPP/RNBQKBNR w KQkq c6
    [3] => rnbqkbnr/pp1ppppp/8/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R b KQkq -
    [4] => r1bqkbnr/pp1ppppp/2n5/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R w KQkq -
    [5] => rnbqkbnr/pp1p1ppp/4p3/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R w KQkq -
    [6] => rnbqkbnr/pp2pppp/3p4/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R w KQkq -
    [7] => rnbqkbnr/pp2pppp/3p4/2p5/3PP3/5N2/PPP2PPP/RNBQKB1R b KQkq d3
    [8] => rnbqkbnr/pp2pppp/3p4/8/3pP3/5N2/PPP2PPP/RNBQKB1R w KQkq -
    [9] => rnbqkbnr/pp2pppp/3p4/8/3NP3/8/PPP2PPP/RNBQKB1R b KQkq -
    [10] => rnbqkb1r/pp2pppp/3p1n2/8/3NP3/8/PPP2PPP/RNBQKB1R w KQkq -
    [11] => rnbqkb1r/pp2pppp/3p1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R b KQkq -
    [12] => rnbqkb1r/1p2pppp/p2p1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -
    [13] => rnbqkb1r/pp2pp1p/3p1np1/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -
    [14] => r1bqkb1r/pp2pppp/2np1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -
    [15] => rnbqkb1r/pp3ppp/3ppn2/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -
)
```

Let's give this a try. Add some comments and get the FEN history.

```php
use Chess\Play\RavPlay;

$movetext = "1.e4 c5 {enters the Sicilian Defense.}
    (2.Nf3 (2... Nc6) (2... e6)
        (2... d6 3.d4 cxd4 4.Nxd4 Nf6 5.Nc3
            (5...a6 {is played in the Najdorf variation.})
            (5...g6 {is played in the Dragon variation.})
            (5...Nc6 {is played in the Classical variation.})
            (5...e6 {is played in the Scheveningen variation.})
        )
    )";

$ravPlay = (new RavPlay($movetext))->validate();

$fen = $ravPlay->getFen();

print_r($fen);
```

Cool! The result obtained is exactly the same as in the previous example.

```text
Array
(
    [0] => rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq -
    [1] => rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3
    [2] => rnbqkbnr/pp1ppppp/8/2p5/4P3/8/PPPP1PPP/RNBQKBNR w KQkq c6
    [3] => rnbqkbnr/pp1ppppp/8/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R b KQkq -
    [4] => r1bqkbnr/pp1ppppp/2n5/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R w KQkq -
    [5] => rnbqkbnr/pp1p1ppp/4p3/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R w KQkq -
    [6] => rnbqkbnr/pp2pppp/3p4/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R w KQkq -
    [7] => rnbqkbnr/pp2pppp/3p4/2p5/3PP3/5N2/PPP2PPP/RNBQKB1R b KQkq d3
    [8] => rnbqkbnr/pp2pppp/3p4/8/3pP3/5N2/PPP2PPP/RNBQKB1R w KQkq -
    [9] => rnbqkbnr/pp2pppp/3p4/8/3NP3/8/PPP2PPP/RNBQKB1R b KQkq -
    [10] => rnbqkb1r/pp2pppp/3p1n2/8/3NP3/8/PPP2PPP/RNBQKB1R w KQkq -
    [11] => rnbqkb1r/pp2pppp/3p1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R b KQkq -
    [12] => rnbqkb1r/1p2pppp/p2p1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -
    [13] => rnbqkb1r/pp2pp1p/3p1np1/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -
    [14] => r1bqkb1r/pp2pppp/2np1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -
    [15] => rnbqkb1r/pp3ppp/3ppn2/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -
)
```

In both cases the `validate()` method will throw a Chess\Exception\PlayException if the RAV movetext is not valid. This is how to obtain the validated movetext.

```php
$movetext = $ravPlay->getRavMovetext()->getMovetext();
```

You may want to remove tabs and spaces from a valid RAV movetext with the help of the `filtered()` method.

```php
$movetext = $ravPlay->getRavMovetext()->filtered();

echo $movetext;
```

```text
1.e4 c5 {enters the Sicilian Defense, the most popular and best-scoring response to White's first move.} (2.Nf3 {is played in about 80% of Master-level games after which there are three main options for Black.} (2...Nc6) (2...e6) (2...d6 {is Black's most common move.} 3.d4 {lines are collectively known as the Open Sicilian.} cxd4 4.Nxd4 Nf6 5.Nc3 {allows Black choose between four major variations: the Najdorf, Dragon, Classical and Scheveningen.} (5...a6 {is played in the Najdorf variation.}) (5...g6 {is played in the Dragon variation.}) (5...Nc6 {is played in the Classical variation.}) (5...e6 {is played in the Scheveningen variation.})))
```

Comments are removed by passing the false value to the first argument of the `filtered()` method.

```php
$movetext = $ravPlay->getRavMovetext()->filtered($comments = false);

echo $movetext;
```

```text
1.e4 c5 (2.Nf3 (2...Nc6) (2...e6) (2...d6 3.d4 cxd4 4.Nxd4 Nf6 5.Nc3 (5...a6) (5...g6) (5...Nc6) (5...e6)))
```

RAV files can also be loaded from a particular FEN position as opposed to the start position.

```php
use Chess\FenToBoard;
use Chess\Play\RavPlay;

$movetext = "1.Ra7 Kg8 2.Kg2 Kf8 3.Kf3 Ke8 4.Ke4 Kd8 5.Kd5 Kc8
    (5...Ke8 6.Kd6 Kf8 7.Ke6 Kg8 8.Kf6 Kh8 9.Kg6 Kg8 10.Ra8#)
    6.Kd6 Kb8
    (6...Kd8 7.Ra8#)
    7.Rc7 Ka8 8.Kc6 Kb8 9.Kb6 Ka8 10.Rc8#";

$board = FenToBoard::create('7k/8/8/8/8/8/8/R6K w - -');

$ravPlay = (new RavPlay($movetext, $board))->validate();

$fen = $ravPlay->getFen();

print_r($fen);
```

```text
Array
(
    [0] => 7k/8/8/8/8/8/8/R6K w - -
    [1] => 7k/R7/8/8/8/8/8/7K b - -
    [2] => 6k1/R7/8/8/8/8/8/7K w - -
    [3] => 6k1/R7/8/8/8/8/6K1/8 b - -
    [4] => 5k2/R7/8/8/8/8/6K1/8 w - -
    [5] => 5k2/R7/8/8/8/5K2/8/8 b - -
    [6] => 4k3/R7/8/8/8/5K2/8/8 w - -
    [7] => 4k3/R7/8/8/4K3/8/8/8 b - -
    [8] => 3k4/R7/8/8/4K3/8/8/8 w - -
    [9] => 3k4/R7/8/3K4/8/8/8/8 b - -
    [10] => 2k5/R7/8/3K4/8/8/8/8 w - -
    [11] => 4k3/R7/8/3K4/8/8/8/8 w - -
    [12] => 4k3/R7/3K4/8/8/8/8/8 b - -
    [13] => 5k2/R7/3K4/8/8/8/8/8 w - -
    [14] => 5k2/R7/4K3/8/8/8/8/8 b - -
    [15] => 6k1/R7/4K3/8/8/8/8/8 w - -
    [16] => 6k1/R7/5K2/8/8/8/8/8 b - -
    [17] => 7k/R7/5K2/8/8/8/8/8 w - -
    [18] => 7k/R7/6K1/8/8/8/8/8 b - -
    [19] => 6k1/R7/6K1/8/8/8/8/8 w - -
    [20] => R5k1/8/6K1/8/8/8/8/8 b - -
    [21] => 2k5/R7/3K4/8/8/8/8/8 b - -
    [22] => 1k6/R7/3K4/8/8/8/8/8 w - -
    [23] => 3k4/R7/3K4/8/8/8/8/8 w - -
    [24] => R2k4/8/3K4/8/8/8/8/8 b - -
    [25] => 1k6/2R5/3K4/8/8/8/8/8 b - -
    [26] => k7/2R5/3K4/8/8/8/8/8 w - -
    [27] => k7/2R5/2K5/8/8/8/8/8 b - -
    [28] => 1k6/2R5/2K5/8/8/8/8/8 w - -
    [29] => 1k6/2R5/1K6/8/8/8/8/8 b - -
    [30] => k7/2R5/1K6/8/8/8/8/8 w - -
    [31] => k1R5/8/1K6/8/8/8/8/8 b - -
)
```

🎉 So this is amazing! That's all we need to read and write chess tutorials, guides and how-tos.
