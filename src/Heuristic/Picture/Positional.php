<?php

namespace Chess\Heuristic\Picture;

use Chess\Evaluation\AttackEvaluation;
use Chess\Evaluation\CenterEvaluation;
use Chess\Evaluation\ConnectivityEvaluation;
use Chess\Evaluation\EaseEvaluation;
use Chess\Evaluation\GuardEvaluation;
use Chess\Evaluation\KingSafetyEvaluation;
use Chess\Evaluation\MaterialEvaluation;
use Chess\Evaluation\PressureEvaluation;
use Chess\Evaluation\SpaceEvaluation;

class Positional extends AbstractHeuristicPicture
{
    protected $dimensions = [
        MaterialEvaluation::class => 25,
        GuardEvaluation::class => 20,
        CenterEvaluation::class => 15,
        ConnectivityEvaluation::class => 10,
        SpaceEvaluation::class => 10,
        KingSafetyEvaluation::class => 5,
        PressureEvaluation::class => 5,
        AttackEvaluation::class => 5,
        EaseEvaluation::class => 5,
    ];
}
