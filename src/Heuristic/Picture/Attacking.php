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
        MaterialEvaluation::class,
        AttackEvaluation::class,
        PressureEvaluation::class,
        GuardEvaluation::class,
        EaseEvaluation::class,
        KingSafetyEvaluation::class,
        ConnectivityEvaluation::class,
        SpaceEvaluation::class,
        CenterEvaluation::class,
    ];
}
