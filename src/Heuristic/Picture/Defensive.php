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
