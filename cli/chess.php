<?php

namespace ChessData\Cli;

require_once __DIR__ . '/../vendor/autoload.php';

use Chess\Game;
use Chess\Grandmaster;
use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;

class ModelPlayCli extends CLI
{
    const FILEPATH = __DIR__.'/../data/json/players.json';

    const PROMPT = 'chess > ';

    protected function setup(Options $options)
    {
        $options->setHelp('Play with an AI.');
        $options->registerArgument('model', 'AI model name. The AIs are stored in the model folder.', true);
        $options->registerArgument('fen', 'FEN string.', false);
    }

    protected function main(Options $options)
    {
        $game = new Game(
            Game::MODE_AI,
            new Grandmaster(self::FILEPATH),
            $options->getArgs()[0]
        );

        if (isset($options->getArgs()[1])) {
            $game->loadFen($options->getArgs()[1]);
        }

        do {
            $move = readline(self::PROMPT);
            if ($move === 'ascii') {
                echo $game->getBoard()->toAsciiString() . PHP_EOL;
            } elseif ($move === 'fen') {
                echo $game->fen() . PHP_EOL;
            } elseif ($move !== 'quit') {
                $game->play('w', $move);
                $response = $game->ai();
                $game->play('b', $response);
                echo self::PROMPT . $game->movetext() . PHP_EOL;
                echo $game->ascii();
            } else {
                break;
            }
        } while (!$game->getBoard()->isMate());
    }
}

$cli = new ModelPlayCli();
$cli->run();
