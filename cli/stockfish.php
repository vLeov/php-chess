<?php

namespace ChessData\Cli;

require_once __DIR__ . '/../vendor/autoload.php';

use Chess\FEN\StrToBoard;
use Chess\UciEngine\Stockfish;
use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;

class StockfishCli extends CLI
{
    protected function setup(Options $options)
    {
        $options->setHelp("Returns Stockfish's response to the given position.");
        $options->registerArgument('fen', 'FEN string.', true);
    }

    protected function main(Options $options)
    {
        $board = (new StrToBoard($options->getArgs()[0]))->create();
        $stockfish = new Stockfish($board);
        $shortFen = $stockfish->shortFen($board->toFen(), 3000);

        echo $shortFen . PHP_EOL;
    }
}

$cli = new StockfishCli();
$cli->run();
