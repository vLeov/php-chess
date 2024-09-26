<?php

namespace Chess\Eval;

use Chess\Tutor\PiecePhrase;
use Chess\Variant\AbstractBoard;
use Chess\Variant\AbstractPiece;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

/**
 * Back-Rank Checkmate Evaluation
 *
 * A back-rank checkmate is a checkmate delivered by a rook or queen along the
 * opponent's back rank. The mated king is unable to move up the board because
 * it is blocked by friendly pawns on the second rank.
 */
class BackRankCheckmateEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    /**
     * The name of the heuristic.
     *
     * @var string
     */
    const NAME = 'Back-rank checkmate';

    /**
     * @param \Chess\Variant\AbstractBoard $board
     */
    public function __construct(AbstractBoard $board)
    {
        $this->board = $board;

        $this->range = [1];

        $this->subject = [
            'White',
            'Black',
        ];

        $this->observation = [
            "has a back-rank checkmate advantage",
        ];

        $wKing = $this->board->piece(Color::W, Piece::K);
        $bKing = $this->board->piece(Color::B, Piece::K);

        if ($this->isOnBackRank($bKing) &&
            $this->isBlocked($bKing) &&
            $this->isDeliverable($bKing) &&
            $this->isThreatened($bKing)
        ) {
            $this->result[Color::W] = 1;
            $this->elaborate($bKing);
        }

        if ($this->isOnBackRank($wKing) &&
            $this->isBlocked($wKing) &&
            $this->isDeliverable($wKing) &&
            $this->isThreatened($wKing)
        ) {
            $this->result[Color::B] = 1;
            $this->elaborate($wKing);
        }

        $this->explain($this->result);
    }

    /**
     * Returns true if the king is on a back-rank.
     *
     * @param \Chess\Variant\AbstractPiece $king
     * @return bool
     */
    private function isOnBackRank(AbstractPiece $king): bool
    {
        if ($king->color === Color::W) {
            return $king->rank() === 1;
        }

        return $king->rank() === $this->board->square::SIZE['ranks'];
    }

    /**
     * Returns true if the king is blocked by friendly pawns.
     *
     * @param \Chess\Variant\AbstractPiece $king
     * @return bool
     */
    private function isBlocked(AbstractPiece $king): bool
    {
        if ($this->isOnBackRankCornerSq($king)) {
            return $this->countBlockingPawns($king) === 2;
        }

        return $this->countBlockingPawns($king) === 3;
    }

    /**
     * Returns true if the king is on a corner square.
     *
     * @param \Chess\Variant\AbstractPiece $king
     * @return bool
     */
    private function isOnBackRankCornerSq(AbstractPiece $king): bool
    {
        $corner = $this->board->square->corner();
        if ($king->color === Color::W) {
            return $king->sq === $corner[0] || $king->sq === $corner[1];
        }

        return $king->sq === $corner[2] || $king->sq === $corner[3];
    }

    /**
     * Returns the number of blocking pawns.
     *
     * @param \Chess\Variant\AbstractPiece $king
     * @return int
     */
    private function countBlockingPawns(AbstractPiece $king): int
    {
        $count = 0;
        foreach ($king->defended() as $defended) {
            if ($defended->id === Piece::P) {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * Returns true if there is a rook or queen on the board.
     *
     * @param \Chess\Variant\AbstractPiece $king
     * @return bool
     */
    private function isDeliverable(AbstractPiece $king): bool
    {
        foreach ($this->board->pieces($king->oppColor()) as $piece) {
            if ($piece->id === Piece::R || $piece->id === Piece::Q) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns true if there is a back-rank threat.
     *
     * @param \Chess\Variant\AbstractPiece $king
     * @return bool
     */
    private function isThreatened(AbstractPiece $king): bool
    {
        $escape = 1;
        foreach ($king->moveSqs() as $sq) {
            if (!in_array($sq, $this->board->square->corner())) {
                $escape *= (int) $this->isDefendedSq($sq);
            }
        }

        return (bool) !$escape;
    }

    /**
     * Returns true if the square is being defended.
     *
     * @param string $sq
     * @return bool
     */
    private function isDefendedSq(string $sq): bool
    {
        $clone = $this->board->clone();
        foreach ($clone->pieces($clone->turn) as $piece) {
            if (in_array($sq, $piece->defendedSqs())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Elaborate on the evaluation.
     *
     * @param \Chess\Variant\AbstractPiece $king
     */
    private function elaborate(AbstractPiece $king): void
    {
        $phrase = PiecePhrase::create($king);

        $this->elaboration[] = "One of the pawns in front of {$phrase} should be moved as long as there is a need to be guarded against back-rank threats.";
    }
}
