<?php

namespace Chess;

class Grandmaster
{
    private string $filepath;

    private array $found = [];

    public function __construct(string $filepath)
    {
        $this->filepath = $filepath;
    }

    public function response(string $movetext): ?array
    {
        $contents = file_get_contents($this->filepath);

        $items = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator(json_decode($contents, true)),
            \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($items as $item) {
            if (isset($item['movetext'])) {
                if (str_starts_with($item['movetext'], $movetext)) {
                    $this->found[] = $item;
                }
            }
        }

        shuffle($this->found);

        if ($this->found) {
            return [
                'move' => $this->move($this->found[0]['movetext'], $movetext),
                'game' => $this->found[0],
            ];
        }

        return null;
    }

    protected function move(string $haystack, string $needle): string
    {
        $moves = array_filter(explode(' ', str_replace($needle, '', $haystack)));
        $current = explode('.', current($moves));
        isset($current[1]) ? $move = $current[1] : $move = $current[0];

        return $move;
    }
}
