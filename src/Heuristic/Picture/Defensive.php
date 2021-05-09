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

class Defensive extends AbstractHeuristicPicture
{
    protected $dimensions = [
        KingSafetyEvaluation::class => 25,
        MaterialEvaluation::class => 20,
        GuardEvaluation::class => 15,
        EaseEvaluation::class => 10,
        ConnectivityEvaluation::class => 10,
        SpaceEvaluation::class => 5,
        CenterEvaluation::class => 5,
        PressureEvaluation::class => 5,
        AttackEvaluation::class => 5,
    ];
}
