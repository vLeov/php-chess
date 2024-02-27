<?php

namespace Chess\UciEngine;

use Chess\UciEngine\Details\Limit;
use Chess\UciEngine\Details\Process;
use Chess\UciEngine\Details\UCIInfoLine;
use Chess\UciEngine\Details\UCIOption;
use Chess\Variant\Classical\Board;

class UciEngine
{
    /**
     * Process for the engine.
     *
     * @var Process
     */
    private Process $process;

    /**
     * Array of UCIOptions
     *
     * @var array
     */
    private array $options;

    public function __construct(string $path)
    {
        $this->process = new Process($path);

        $this->process->writeLine('uci');
        $this->process->readUntil('uciok');

        $this->process->writeLine('isready');
        $this->process->readUntil('readyok');

        $this->options = $this->readOptions();
    }

    public function __destruct()
    {
        $this->process->writeLine('quit');
    }

    /**
     * Returns an array of key value pairs with the value
     * being the UCIOption and the key being the name of the option.
     *
     * @return array
     */
    private function readOptions(): array
    {
        $this->process->writeLine('uci');

        $options = [];

        while (true) {
            $line = $this->process->readLine();

            if (str_contains($line, 'uciok')) {
                break;
            }

            if (str_contains($line, 'option')) {
                $option = UCIOption::createFromLine($line);
                $options[$option->name] = $option;
            }
        }

        return $options;
    }

    /**
     * Get current UCIOptions
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set an uci option for the engine.
     *
     * @param string $name
     * @param string $value
     * @return \Chess\UciEngine\Stockfish
     */
    public function setOption(string $name, string $value): UciEngine
    {
        if (!array_key_exists($name, $this->options)) {
            throw new \InvalidArgumentException("Option $name does not exist");
        }

        if ($value === '') {
            $this->process->writeLine("setoption name $name");
        }

        $this->options[$name]->value = $value;

        $this->process->writeLine("setoption name $name value $value");

        return $this;
    }

    /**
     * Analyse the board with the given limit and
     * return the bestmove and all uci info lines.
     *
     * @param Board $board
     * @param Limit $limit
     * @return array
     */
    public function analyse(Board $board, Limit $limit): array
    {
        $this->process->writeLine("position fen " . $board->toFen());
        $this->process->writeLine($this->buildGoCommand($limit));
        $output = $this->process->readUntil('bestmove');

        return [
            "bestmove" => explode(' ', end($output))[1],
            "info" => array_map(function ($line) {
                return new UCIInfoLine($line);
            }, $output)
        ];
    }

    /**
     * Sends the ucinewgame command to the engine. Does not reset the options.
     *
     * @return void
     */
    public function newGame(): void
    {
        $this->process->writeLine("ucinewgame");
    }

    /**
     * Reset all options to their default values.
     *
     * @return void
     */
    public function resetOptions(): void
    {
        foreach ($this->options as $option) {
            $this->setOption($option->name, $option->default);
        }
    }

    /**
     * Build the go command based on the given limit.
     *
     * @param Limit $limit
     * @return string
     */
    private function buildGoCommand(Limit $limit): string
    {
        $command = 'go';

        if ($limit->getMovetime() !== null) {
            $command .= ' movetime ' . $limit->getMovetime();
        }

        if ($limit->getDepth() !== null) {
            $command .= ' depth ' . $limit->getDepth();
        }

        if ($limit->getNodes() !== null) {
            $command .= ' nodes ' . $limit->getNodes();
        }

        if ($limit->getMate() !== null) {
            $command .= ' mate ' . $limit->getMate();
        }

        if ($limit->getWtime() !== null) {
            $command .= ' wtime ' . $limit->getWtime();
        }

        if ($limit->getBtime() !== null) {
            $command .= ' btime ' . $limit->getBtime();
        }

        if ($limit->getWinc() !== null) {
            $command .= ' winc ' . $limit->getWinc();
        }

        if ($limit->getBlackInc() !== null) {
            $command .= ' binc ' . $limit->getBlackInc();
        }

        if ($limit->getRemainingMoves() !== null) {
            $command .= ' movestogo ' . $limit->getRemainingMoves();
        }

        return $command;
    }
}
