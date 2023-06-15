<?php

namespace ChessData\Cli;

require_once __DIR__ . '/../vendor/autoload.php';

use Chess\Player\PgnPlayer;

$movetext = '1.e4 c5 2.Nf3 d6 3.d4 cxd4 4.Nxd4 Nf6';

$board = (new PgnPlayer($movetext))
    ->play()
    ->getBoard();

$board->play('w', 'Bb5+');

var_dump($board->isCheck());

exit;
