<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Board;
use Chess\HeuristicPicture;
use Chess\ML\Supervised\AbstractPredictor;
use Chess\PGN\Symbol;
use Rubix\ML\Datasets\Unlabeled;

class PermutationPredictor extends AbstractPredictor
{
    protected function evaluate(Board $clone): array
    {
        $balance = (new HeuristicPicture($clone->getMovetext(), $clone))->take()->getBalance();
        $dataset = new Unlabeled($balance);
        $end = end($balance);

        return [
            'label' => (new GeometricSumLabeller())->label($end),
            'prediction' => current($this->estimator->predict($dataset)),
        ];
    }

    protected function sort(string $color): AbstractPredictor
    {
        usort($this->result, function ($a, $b) use ($color) {
            if ($color === Symbol::WHITE) {
                $current = (current($b)['label'] <=> current($a)['label']) * 10 +
                    (current($b)['prediction'] <=> current($a)['prediction']);
            } else {
                $current = (current($a)['label'] <=> current($b)['label']) * 10 +
                    (current($a)['prediction'] <=> current($b)['prediction']);
            }
            return $current;
        });

        return $this;
    }

    protected function find(): string
    {
        $diffs = [];
        foreach ($this->result as $key => $val) {
            $current = current($val);
            $diffs[$key] = abs($current['label'] - $current['prediction']);
        }
        $mins = array_keys($diffs, min($diffs));
        shuffle($mins);
        $min = $mins[0];

        return key($this->result[$min]);
    }
}
