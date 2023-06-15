# Play Like a Pro

✨ The [players.json](https://github.com/chesslablab/chess-server/blob/master/data/players.json) file in the [Chess Server](https://github.com/chesslablab/chess-server) contains thousands of games by titled FIDE players. This file can be generated and customized with the command line tools available in the [Chess Data](https://github.com/chesslablab/chess-data) repo.

[Chess\Grandmaster](https://github.com/chesslablab/php-chess/blob/master/tests/unit/GrandmasterTest.php) figures out the next move to be made based on the JSON file that is passed to its constructor. Please make sure to first create one for it or feel free to use the players.json linked above.

```php
use Chess\Grandmaster;
use Chess\Variant\Classical\Board;

$board = new Board();
$board->play('w', 'e4');

$move = (new Grandmaster(__DIR__.'/../data/players.json'))->move($board);

print_r($move);
```

```text
stdClass Object
(
    [move] => e5
    [game] => Array
        (
            [Event] => Barmen-B
            [Site] => Barmen
            [Date] => 1905.??.??
            [White] => Neumann, Augustin
            [Black] => Spielmann, Rudolf
            [Result] => 1/2-1/2
            [ECO] => C63
            [movetext] => 1.e4 e5 2.Nf3 Nc6 3.Bb5 f5 4.exf5 e4 5.Qe2 Qe7 6.Bxc6 bxc6 7.Nd4 Nf6 8.O-O c5 9.Nb5 d5 10.f3 c6 11.N5c3 Bxf5 12.fxe4 Bxe4 13.Nxe4 Qxe4 14.Qa6 Qe6 15.d3 Be7 16.Bf4 O-O 17.Nd2 Nh5 18.Rae1 Qg4 19.h3 Qg6 20.Be5 Bh4 21.Rxf8+ Rxf8 22.Rf1 Rxf1+ 23.Kxf1 Qe6 24.Nf3 Bg3 25.Bxg3 Nxg3+ 26.Kf2 Nf5 27.Kg1 h6 28.Qxa7 Qe3+ 29.Kh2 Qf4+ 30.Kg1 Qe3+ 31.Kh2 Qf2 32.Qd7 Ne3 33.Qe8+ Kh7
        )

)
```

1.e4 e5 is the move that a grandmaster would play. As you can see in this example, Chess\Grandmaster could find a response to 1.e4 returning the corresponding game's metadata.

🎉 Let's now put our knowledge of chess openings to the test.
