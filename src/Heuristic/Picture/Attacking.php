<?php

namespace Chess\Heuristic\Picture;

use Chess\Evaluation\Attack as AttackEvaluation;
use Chess\Evaluation\Center as CenterEvaluation;
use Chess\Evaluation\Connectivity as ConnectivityEvaluation;
use Chess\Evaluation\Ease as EaseEvaluation;
use Chess\Evaluation\Guard as GuardEvaluation;
use Chess\Evaluation\KingSafety as KingSafetyEvaluation;
use Chess\Evaluation\Material as MaterialEvaluation;
use Chess\Evaluation\Pressure as PressureEvaluation;
use Chess\Evaluation\Space as SpaceEvaluation;

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
