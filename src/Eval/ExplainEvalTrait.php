<?php

namespace Chess\Eval;

use Chess\Variant\Classical\PGN\AN\Color;

trait ExplainEvalTrait
{
    /**
     * Range.
     *
     * @var array
     */
    protected array $range;

    /**
     * Subject.
     *
     * @var array
     */
    protected array $subject;

    /**
     * Observation.
     *
     * @var array
     */
    protected array $observation;

    /**
     * Explanation.
     *
     * @var array
     */
    protected array $explanation = [];

    /**
     * Returns the explanation of the evaluation.
     *
     * @return array
     */
    public function getExplanation(): array
    {
        return $this->explanation;
    }

    /**
     * Returns the meaning of the result.
     *
     * @param array $result
     * @return string|null
     */
    protected function meaning(array $result): ?string
    {
        $meanings = $this->meanings();

        $diff = $result[Color::W] - $result[Color::B];

        if ($diff > 0) {
            foreach ($meanings[Color::W] as $item) {
                if ($diff >= $item['diff']) {
                    return $item['meaning'];
                }
            }
        }

        if ($diff < 0) {
            foreach ($meanings[Color::B] as $item) {
                if ($diff <= $item['diff']) {
                    return $item['meaning'];
                }
            }
        }

        return null;
    }

    /**
     * Returns an array of meanings based on a difference value.
     *
     * @return array
     */
    protected function meanings(): array
    {
        $diff = $this->range[0];

        foreach ($this->observation as $key => $val) {
            $meanings[Color::W][] = [
                'diff' => $diff,
                'meaning' => "{$this->subject[0]} {$val}."
            ];
            $meanings[Color::B][] = [
                'diff' => $diff * -1,
                'meaning' => "{$this->subject[1]} {$val}."
            ];
            $diff += intdiv($this->range[1] - $this->range[0], count($this->observation) - 1);
        }

        return [
            Color::W => array_reverse($meanings[Color::W]),
            Color::B => array_reverse($meanings[Color::B]),
        ];
    }

    /**
     * Explains the result obtained.
     *
     * @param array $result
     */
    protected function explain(array $result): void
    {
        if ($meaning = $this->meaning($result)) {
            $this->explanation[] = $meaning;
        }
    }
}
