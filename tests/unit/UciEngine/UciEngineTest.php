<?php

namespace Chess\Tests\Unit\UciEngine;

use Chess\Tests\AbstractUnitTestCase;
use Chess\UciEngine\UciEngine;
use Chess\UciEngine\Details\Limit;
use Chess\Variant\Classical\Board;

class UciEngineTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function uci_engine_stockfish()
    {
        $stockfish = new UciEngine('/usr/games/stockfish');

        $this->assertTrue(is_a($stockfish, UciEngine::class));
    }

    /**
     * @test
     */
    public function get_options()
    {
        $stockfish = new UciEngine('/usr/games/stockfish');

        $expected = [
            'Debug Log File',
            'Threads',
            'Hash',
            'Clear Hash',
            'Ponder',
            'MultiPV',
            'Skill Level',
            'Move Overhead',
            'Slow Mover',
            'nodestime',
            'UCI_Chess960',
            'UCI_AnalyseMode',
            'UCI_LimitStrength',
            'UCI_Elo',
            'UCI_ShowWDL',
            'SyzygyPath',
            'SyzygyProbeDepth',
            'Syzygy50MoveRule',
            'SyzygyProbeLimit',
            'Use NNUE',
            'EvalFile',
        ];

        $options = $stockfish->getOptions();

        $this->assertSame($expected, array_keys($options));
    }

    /**
     * @test
     */
    public function analyse_e4_limit_time()
    {
        $board = new Board();
        $board->play('w', 'e4');

        $stockfish = new UciEngine('/usr/games/stockfish');
        $limit = (new Limit())->setMovetime(3000);
        $analysis = $stockfish->analyse($board, $limit);

        $expected = 'c7c5';

        $this->assertSame($expected, $analysis['bestmove']);
    }

    /**
     * @test
     */
    public function analyse_e4_limit_depth_set_options()
    {
        $board = new Board();
        $board->play('w', 'e4');

        $stockfish = (new UciEngine('/usr/games/stockfish'))
            ->setOption('Skill Level', 20)
            ->setOption('UCI_Elo', 1500);

        $limit = (new Limit())->setDepth(8);

        $analysis = $stockfish->analyse($board, $limit);

        $expected = 'c7c5';

        $this->assertSame($expected, $analysis['bestmove']);
    }
}
