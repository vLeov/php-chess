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

class Attacking extends AbstractHeuristicPicture
{
    protected $dimensions = [
        MaterialEvaluation::class => 25,
        AttackEvaluation::class => 20,
        PressureEvaluation::class => 15,
        GuardEvaluation::class => 10,
        EaseEvaluation::class => 10,
        KingSafetyEvaluation::class => 5,
        ConnectivityEvaluation::class => 5,
        SpaceEvaluation::class => 5,
        CenterEvaluation::class => 5,
    ];
}
