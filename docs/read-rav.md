# Read RAV

✨ RAV stands for Recursive Annotation Variation. This format is especially useful to write and read tutorials about openings, notable games, chess studies and so on.

RAV is an extension of the Standard Algebaric Notation (SAN) format and allows to annotate chess variations. After all, a RAV movetext is still a SAN movetext with support for comments. Comments are enclosed in curly brackets. Variations are enclosed in parentheses which can be nested recursively as many times as required with the trait that the previous move may need to be undone in order to play a certain variation.

The example below describes how to play the Open Sicilian.

> 1.e4 c5 {enters the Sicilian Defense, the most popular and best-scoring response to White's first move.} (2.Nf3 {is played in about 80% of Master-level games after which there are three main options for Black.} (2... Nc6) (2... e6) (2... d6 {is Black's most common move.} 3.d4 {lines are collectively known as the Open Sicilian.} cxd4 4.Nxd4 Nf6 5.Nc3 {allows Black choose between four major variations: the Najdorf, Dragon, Classical and Scheveningen.} (5...a6 {is played in the Najdorf variation.}) (5...g6 {is played in the Dragon variation.}) (5...Nc6 {is played in the Classical variation.}) (5...e6 {is played in the Scheveningen variation.})))

Sicilian Defense. (2023, July 2). In Wikipedia. https://en.wikipedia.org/wiki/Sicilian_Defence

Then all you need is a RAV reader.

![Figure 1](https://github.com/chesslablab/php-chess/blob/master/docs/read-rav_01.png)
Figure 1. The response received from PHP Chess can be displayed as an HTML table.

Similarly as with Chess\Play\SanPlay and Chess\Play\LanPlay, [Chess\Play\RavPlay](https://github.com/chesslablab/php-chess/blob/master/tests/unit/Play/RavPlayTest.php) allows to play a RAV movetext. The most important method in this class is the fen() method. This method calculates the FEN history of a RAV movetext to be displayed for reading purposes as shown in Figure 1.

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

$ravPlay = new RavPlay($movetext);

$fen = $ravPlay
    ->fen()
    ->getFen();

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

$ravPlay = new RavPlay($movetext);

$fen = $ravPlay
    ->fen()
    ->getFen();

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

The fen() method will throw a Chess\Exception\PlayException if the RAV movetext is not valid, so this is how to obtain a validated movetext.

```php
$movetext = $ravPlay->getRavMovetext()->getMovetext();
```

You may want to remove tabs and spaces from a valid RAV movetext with the help of the filtered() method.

```php
$movetext = $ravPlay->getRavMovetext()->filtered();

echo $movetext;
```

```text
1.e4 c5 {enters the Sicilian Defense, the most popular and best-scoring response to White's first move.} (2.Nf3 {is played in about 80% of Master-level games after which there are three main options for Black.} (2...Nc6) (2...e6) (2...d6 {is Black's most common move.} 3.d4 {lines are collectively known as the Open Sicilian.} cxd4 4.Nxd4 Nf6 5.Nc3 {allows Black choose between four major variations: the Najdorf, Dragon, Classical and Scheveningen.} (5...a6 {is played in the Najdorf variation.}) (5...g6 {is played in the Dragon variation.}) (5...Nc6 {is played in the Classical variation.}) (5...e6 {is played in the Scheveningen variation.})))
```

Also comments can be easily removed using the filtered() method.

```php
$movetext = $ravPlay->getRavMovetext()->filtered($comments = false);

echo $movetext;
```

```text
1.e4 c5 (2.Nf3 (2...Nc6) (2...e6) (2...d6 3.d4 cxd4 4.Nxd4 Nf6 5.Nc3 (5...a6) (5...g6) (5...Nc6) (5...e6)))
```

🎉 So this is amazing! That's all we need to read and write chess tutorials, guides and how-tos.
