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

class Defensive extends AbstractHeuristicPicture
{
    protected $dimensions = [
        KingSafetyEvaluation::class,
        MaterialEvaluation::class,
        GuardEvaluation::class,
        EaseEvaluation::class,
        ConnectivityEvaluation::class,
        SpaceEvaluation::class,
        CenterEvaluation::class,
        PressureEvaluation::class,
        AttackEvaluation::class,
    ];
}
