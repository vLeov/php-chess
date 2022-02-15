<?php

namespace Chess\Media;

use Chess\Board;

class BoardToGif
{
    protected $board;

    protected $flip;

    protected $frames = [];

    public function __construct(Board $board, bool $flip = false)
    {
        $this->board = $board;

        $this->flip = $flip;
    }

    public function output(string $filepath)
    {
        if (!file_exists($filepath)) {
            throw new \InvalidArgumentException('The folder does not exist.');
        }

        $filename = uniqid();

        $this->frames($filepath, $filename)
            ->animate(escapeshellarg($filepath), $filename)
            ->cleanup($filepath, $filename);

        return $filename.'.gif';
    }

    private function frames(string $filepath, string $filename)
    {
        $salt = uniqid();
        $board = new Board();
        $boardToPng = new BoardToPng($board, $this->flip);
        foreach ($this->board->getHistory() as $key => $item) {
            $n = sprintf("%02d", $key);
            $board->play($item->move->color, $item->move->pgn);
            $this->frames[] = $boardToPng->setBoard($board)->output($filepath, $filename);
        }

        return $this;
    }

    private function animate(string $filepath, string $filename)
    {
        $cmd = "convert -delay 100 {$filepath}/{$filename}*.png {$filepath}/{$filename}.gif";
        $escapedCmd = escapeshellcmd($cmd);
        exec($escapedCmd);

        return $this;
    }

    private function cleanup(string $filepath, string $filename)
    {
        if (file_exists("{$filepath}/$filename.gif")) {
            array_map('unlink', glob($filepath . '/*.png'));
        }
    }
}
