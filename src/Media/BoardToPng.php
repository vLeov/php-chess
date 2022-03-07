<?php

namespace Chess\Media;

use Chess\Ascii;
use Chess\Board;
use Imagine\Gd\Imagine;
use Imagine\Image\Point;

class BoardToPng
{
    const FILEPATH = __DIR__ . '/../../img';

    protected $board;

    protected $imagine;

    protected $flip;

    public function __construct(Board $board, bool $flip = false)
    {
        $this->board = $board;

        $this->imagine = new Imagine();

        $this->flip = $flip;
    }

    public function setBoard(Board $board)
    {
        $this->board = $board;

        return $this;
    }

    public function output(string $filepath, string $salt = '')
    {
        $chessboard = $this->imagine->open(self::FILEPATH . '/chessboard_480.png');
        $array = (new Ascii())->toArray($this->board, $this->flip);
        $x = $y = 0;
        foreach ($array as $i => $rank) {
            foreach ($rank as $j => $piece) {
                if ($piece !== ' . ') {
                    $filename = trim($piece);
                    $image = $this->imagine->open(self::FILEPATH . "/pieces/$filename.png");
                    $chessboard->paste($image, new Point($x, $y));
                }
                $x += 60;
            }
            $x = 0;
            $y += 60;
        }

        if ($salt) {
            $filename = $salt.'_'.uniqid().'.png';
        } else {
            $filename = uniqid().'.png';
        }

        $chessboard->save("{$filepath}/{$filename}");

        return $filename;
    }
}
