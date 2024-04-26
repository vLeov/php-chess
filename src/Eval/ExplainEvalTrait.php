<?php

namespace Chess\Eval;

use Chess\Variant\Classical\PGN\AN\Color;

trait ExplainEvalTrait
{
    protected array $explanation = [];

    public function getExplanation()
    {
        return $this->explanation;
    }

    protected function sentence(array $result): ?string
    {
        $diff = $result[Color::W] - $result[Color::B];

        if ($diff > 0) {
            foreach ($this->phrase[Color::W] as $item) {
                if ($diff >= $item['diff']) {
                    return $item['meaning'];
                }
            }
        }

        if ($diff < 0) {
            foreach ($this->phrase[Color::B] as $item) {
                if ($diff <= $item['diff']) {
                    return $item['meaning'];
                }
            }
        }

        return null;
    }

    /**
     * Explain the result.
     *
     * @param array $result
     */
    protected function explain(array $result): void
    {
        if ($sentence = $this->sentence($result)) {
            $this->explanation[] = $sentence;
        }
    }
}
