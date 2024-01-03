<?php

namespace Chess\Function;

use Chess\Eval\AbsoluteForkEval;
use Chess\Eval\AbsolutePinEval;
use Chess\Eval\AbsoluteSkewerEval;
use Chess\Eval\AdvancedPawnEval;
use Chess\Eval\AttackEval;
use Chess\Eval\BackwardPawnEval;
use Chess\Eval\BadBishopEval;
use Chess\Eval\BishopOutpostEval;
use Chess\Eval\BishopPairEval;
use Chess\Eval\CenterEval;
use Chess\Eval\ConnectivityEval;
use Chess\Eval\DefenseEval;
use Chess\Eval\DirectOppositionEval;
use Chess\Eval\DoubledPawnEval;
use Chess\Eval\InverseEvalInterface;
use Chess\Eval\IsolatedPawnEval;
use Chess\Eval\KingSafetyEval;
use Chess\Eval\KnightOutpostEval;
use Chess\Eval\MaterialEval;
use Chess\Eval\PassedPawnEval;
use Chess\Eval\PressureEval;
use Chess\Eval\ProtectionEval;
use Chess\Eval\RelativeForkEval;
use Chess\Eval\RelativePinEval;
use Chess\Eval\SpaceEval;
use Chess\Eval\SqOutpostEval;
use Chess\Eval\ThreatEval;

/**
 * StandardFunction
 *
 * Standard evaluation function.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
class StandardFunction
{
    /**
     * The evaluation features.
     *
     * @var array
     */
    protected $eval = [
        MaterialEval::class => 30,
        CenterEval::class => 5,
        ConnectivityEval::class => 5,
        SpaceEval::class => 5,
        PressureEval::class => 5,
        KingSafetyEval::class => 5,
        ProtectionEval::class => 5,
        ThreatEval::class => 5,
        AttackEval::class => 5,
        DoubledPawnEval::class => 5,
        PassedPawnEval::class => 5,
        AdvancedPawnEval::class => 5,
        IsolatedPawnEval::class => 5,
        BackwardPawnEval::class => 5,
        DefenseEval::class => 5,
        AbsoluteSkewerEval::class => 5,
        AbsolutePinEval::class => 5,
        RelativePinEval::class => 5,
        AbsoluteForkEval::class => 5,
        RelativeForkEval::class => 5,
        SqOutpostEval::class => 5,
        KnightOutpostEval::class => 5,
        BishopOutpostEval::class => 5,
        BishopPairEval::class => 5,
        BadBishopEval::class => 5,
        DirectOppositionEval::class => 5,
    ];

    /**
     * Returns the evaluation features.
     *
     * @return array
     */
    public function getEval(): array
    {
        return $this->eval;
    }

    /**
     * Returns the evaluation names.
     *
     * @return array
     */
    public function names(): array
    {
        foreach ($this->eval as $key => $val) {
            $names[] = (new \ReflectionClass($key))->getConstant('NAME');
        }

        return $names;
    }

    /**
     * Returns the evaluation weights.
     *
     * @return array
     */
    public function weights(): array
    {
        return array_values($this->eval);
    }
}
