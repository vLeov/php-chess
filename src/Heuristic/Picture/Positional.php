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
