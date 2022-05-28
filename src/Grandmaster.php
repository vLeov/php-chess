<?php

namespace Chess;

class Grandmaster
{
    private string $filepath;

    private array $movetexts = [];

    public function __construct(string $filepath)
    {
        $this->filepath = $filepath;
    }

    public function response(string $movetext): ?string
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
            $current = explode('.', current($moves));
            isset($current[1]) ? $response = $current[1] : $response = $current[0];
            return $response;
        }

        return null;
    }
}
