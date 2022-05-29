<?php

namespace Chess;

use Chess\FEN\BoardToStr;
use Chess\FEN\ShortStrToPgn;
use Chess\FEN\StrToBoard;
use Chess\PGN\AN\Castle;
use Chess\PGN\AN\Color;
use Chess\ML\Supervised\Regression\GeometricSumPredictor;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;

/**
 * Game
 *
 * Game is the main component of the PHP Chess Server, a wrapper for the
 * Chess\Board especially suited for playing chess online.
 *
 * @author Jordi Bassagañas
 * @license GPL
 * @link https://github.com/chesslablab/chess-server
 */
class Game
{
    const MODE_AI           = 'MODE_AI';
    const MODE_ANALYSIS     = 'MODE_ANALYSIS';
    const MODE_GRANDMASTER  = 'MODE_GRANDMASTER';
    const MODE_LOAD_FEN     = 'MODE_LOAD_FEN';
    const MODE_LOAD_PGN     = 'MODE_LOAD_PGN';
    const MODE_PLAY         = 'MODE_PLAY';

    const MODEL_FOLDER      = __DIR__.'/../model/';

    /**
     * Chess board.
     *
     * @var \Chess\Board
     */
    private Board $board;

    /**
     * Mode.
     *
     * @var string
     */
    private string $mode;

    /**
     * Grandmaster.
     *
     * @var Grandmaster
     */
    private Grandmaster $grandmaster;

    /**
     * Estimator.
     *
     * @var PersistentModel
     */
    private PersistentModel $estimator;

    /**
     * Constructor.
     *
     * @param mixed $mode
     * @param mixed $grandmasterFilepath
     * @param mixed $model
     */
    public function __construct(
        null|string $mode = null,
        null|string $grandmasterFilepath = null,
        null|string $model = null
    ) {
        $this->board = new Board();
        $this->mode = $mode ?? self::MODE_ANALYSIS;

        if ($grandmasterFilepath) {
            $this->grandmaster = new Grandmaster($grandmasterFilepath);
        }

        if ($model) {
            $this->estimator = PersistentModel::load(new Filesystem(self::MODEL_FOLDER.$model));
        }
    }

    /**
     * Returns the Chess\Board object.
     *
     * @return \Chess\Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * Returns the game mode.
     *
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * Sets the Chess\Board object.
     *
     * @return \Chess\Game
     */
    public function setBoard(Board $board): Game
    {
        return $this;
    }

    /**
     * Returns the state of the board.
     *
     * @return object
     */
    public function state(): object
    {
        $history = $this->board->getHistory();
        $end = end($history);
        return (object) [
            'turn' => $this->board->getTurn(),
            'pgn' => $end ? $end->move->pgn : null,
            'castlingAbility' => $this->board->getCastlingAbility(),
            'movetext' => $this->board->getMovetext(),
            'fen' => $this->board->toFen(),
            'isCheck' => $this->board->isCheck(),
            'isMate' => $this->board->isMate(),
            'isStalemate' => $this->board->isStalemate(),
        ];
    }

    /**
     * Makes a move.
     *
     * @param string $color
     * @param string $pgn
     * @return bool true if the move can be made; otherwise false
     */
    public function play(string $color, string $pgn): bool
    {
        return $this->board->play($color, $pgn);
    }

    /**
     * Returns a computer response to the current position. This method is to be
     * used in either Game::MODE_AI or Game::MODE_GRANDMASTER otherwise it
     * returns null.
     *
     * @return mixed sring|null
     */
    public function response(): ?object
    {
        $response = $this->grandmaster->response($this);

        if ($this->mode === Game::MODE_AI) {
            if ($response) {
                return $response;
            } else {
                $move = (new GeometricSumPredictor($this->board, $this->estimator))
                    ->predict();
                return [
                    'move' => $move,
                ];
            }
        } elseif ($this->mode === Game::MODE_GRANDMASTER) {
            return $response;
        }

        return null;
    }

    /**
     * Loads a FEN string allowing to continue a chess game.
     *
     * @param string
     */
    public function loadFen(string $string): void
    {
        $this->board = (new StrToBoard($string))->create();
    }

    /**
     * Loads a PGN movetext allowing to continue a chess game.
     *
     * @param string
     */
    public function loadPgn(string $movetext): void
    {
        $this->board = (new Player($movetext))->play()->getBoard();
    }

    /**
     * Makes a move in short FEN format. Only the piece placement and the side
     * to move are required.
     *
     * @param string $toShortFen
     * @return mixed bool|string
     */
    public function playFen(string $toShortFen): bool|string
    {
        $fromFen = (new BoardToStr($this->board))->create();

        $fromPiecePlacement = explode(' ', $fromFen)[0];
        $toPiecePlacement = explode(' ', $toShortFen)[0];
        $fromRanks = explode('/', $fromPiecePlacement);
        $toRanks = explode('/', $toPiecePlacement);

        if (
          'K2R' === substr($fromRanks[7], -3) &&
          'KR' === substr($toRanks[7], -2) &&
          $this->board->play(Color::W, Castle::SHORT)
        ) {
            return true;
        } elseif (
          'R3K' === substr($fromRanks[7], 0, 3) &&
          'R1K' === substr($toRanks[7], 0, 3) &&
          $this->board->play(Color::W, Castle::LONG)
        ) {
            return true;
        } elseif (
          'k2r' === substr($fromRanks[0], -3) &&
          'kr' === substr($toRanks[0], -2) &&
          $this->board->play(Color::B, Castle::SHORT)
        ) {
            return true;
        } elseif (
          'r3k' === substr($fromRanks[0], 0, 3) &&
          'r1k' === substr($toRanks[0], 0, 3) &&
          $this->board->play(Color::B, Castle::LONG)
        ) {
            return true;
        }

        $pgn = (new ShortStrToPgn($fromFen, $toShortFen))->create();
        $color = key($pgn);
        $result = current($pgn);

        if ($result) {
            $clone = unserialize(serialize($this->board));
            $clone->play($color, $result);
            $clone->isMate() ? $check = '#' : ($clone->isCheck() ? $check = '+' : $check = '');
            return $this->board->play($color, $result.$check);
        }

        return false;
    }
}
