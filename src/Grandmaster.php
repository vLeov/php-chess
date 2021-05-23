<?php

namespace Chess;

class Grandmaster
{
    private $filepath;

    private $movetexts;

    public function __construct(string $filepath)
    {
        $this->filepath = $filepath;

        $this->movetexts = [];
    }

    public function response(string $movetext)
    {
        $file = new \SplFileObject($this->filepath);
        while (!$file->eof()) {
            $line = str_replace('"', '', $file->fgets());
            if (str_starts_with($line, $movetext)) {
                $this->movetexts[] = $line;
            }
        }
        shuffle($this->movetexts);
        if ($this->movetexts) {
            $moves = array_filter(
                explode(' ', str_replace($movetext, '', $this->movetexts[0]))
            );
            return current($moves);
        }

        return null;
    }
}
