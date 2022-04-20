<?php

namespace Chess\Piece;

use Chess\FEN\Field\CastlingAbility;
use Chess\PGN\AN\Castle;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;

/**
 * King class.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class King extends AbstractPiece
{
    public static $castlingRule = [
        Color::W => [
            Piece::K => [
                Castle::SHORT => [
                    'sqs' => [
                        'f' => 'f1',
                        'g' => 'g1',
                    ],
                    'sq' => [
                        'current' => 'e1',
                        'next' => 'g1',
                    ],
                ],
                Castle::LONG => [
                    'sqs' => [
                        'b' => 'b1',
                        'c' => 'c1',
                        'd' => 'd1',
                    ],
                    'sq' => [
                        'current' => 'e1',
                        'next' => 'c1',
                    ],
                ],
            ],
            Piece::R => [
                Castle::SHORT => [
                    'sq' => [
                        'current' => 'h1',
                        'next' => 'f1',
                    ],
                ],
                Castle::LONG => [
                    'sq' => [
                        'current' => 'a1',
                        'next' => 'd1',
                    ],
                ],
            ],
        ],
        Color::B => [
            Piece::K => [
                Castle::SHORT => [
                    'sqs' => [
                        'f' => 'f8',
                        'g' => 'g8',
                    ],
                    'sq' => [
                        'current' => 'e8',
                        'next' => 'g8',
                    ],
                ],
                Castle::LONG => [
                    'sqs' => [
                        'b' => 'b8',
                        'c' => 'c8',
                        'd' => 'd8',
                    ],
                    'sq' => [
                        'current' => 'e8',
                        'next' => 'c8',
                    ],
                ],
            ],
            Piece::R => [
                Castle::SHORT => [
                    'sq' => [
                        'current' => 'h8',
                        'next' => 'f8',
                    ],
                ],
                Castle::LONG => [
                    'sq' => [
                        'current' => 'a8',
                        'next' => 'd8',
                    ],
                ],
            ],
        ],
    ];

    /**
     * @var \Chess\Piece\Rook
     */
    private Rook $rook;

    /**
     * @var \Chess\Piece\Bishop
     */
    private Bishop $bishop;

    /**
     * Constructor.
     *
     * @param string $color
     * @param string $sq
     */
    public function __construct(string $color, string $sq)
    {
        parent::__construct($color, $sq, Piece::K);

        $this->rook = new Rook($color, $sq, RookType::SLIDER);
        $this->bishop = new Bishop($color, $sq);

        $this->setTravel();
    }

    public function sqCastleLong(): ?string
    {
        $rule = self::$castlingRule[$this->getColor()][Piece::K][Castle::LONG];

        if (CastlingAbility::long($this->board->getCastlingAbility(), $this->getColor())) {
            if (
                in_array($rule['sqs']['b'], $this->board->getSqEval()->free) &&
                in_array($rule['sqs']['c'], $this->board->getSqEval()->free) &&
                in_array($rule['sqs']['d'], $this->board->getSqEval()->free) &&
                !in_array($rule['sqs']['b'], $this->board->getSpaceEval()->{$this->getOppColor()}) &&
                !in_array($rule['sqs']['c'], $this->board->getSpaceEval()->{$this->getOppColor()}) &&
                !in_array($rule['sqs']['d'], $this->board->getSpaceEval()->{$this->getOppColor()})
            ) {
                return $rule['sq']['next'];
            }
        }

        return null;
    }

    public function sqCastleShort(): ?string
    {
        $rule = self::$castlingRule[$this->getColor()][Piece::K][Castle::SHORT];

        if (CastlingAbility::short($this->board->getCastlingAbility(), $this->getColor())) {
            if (
                in_array($rule['sqs']['f'], $this->board->getSqEval()->free) &&
                in_array($rule['sqs']['g'], $this->board->getSqEval()->free) &&
                !in_array($rule['sqs']['f'], $this->board->getSpaceEval()->{$this->getOppColor()}) &&
                !in_array($rule['sqs']['g'], $this->board->getSpaceEval()->{$this->getOppColor()})
            ) {
                return $rule['sq']['next'];
            }
        }

        return null;
    }

    protected function sqsCaptures(): ?array
    {
        $sqsCaptures = array_intersect(
            array_values((array)$this->travel),
            $this->board->getSqEval()->used->{$this->getOppColor()}
        );

        return array_diff($sqsCaptures, $this->board->getDefenseEval()->{$this->getOppColor()});
    }

    protected function sqsKing(): ?array
    {
        $sqsKing = array_intersect(array_values((array)$this->travel), $this->board->getSqEval()->free);

        return array_diff($sqsKing, $this->board->getSpaceEval()->{$this->getOppColor()});
    }

    /**
     * Gets the castle rook.
     *
     * @param array $pieces
     * @return mixed \Chess\Piece\Rook|null
     */
    public function getCastleRook(array $pieces): ?Rook
    {
        $rule = self::$castlingRule[$this->getColor()][Piece::R];

        foreach ($pieces as $piece) {
            if (
                $piece->getId() === Piece::R &&
                $piece->getSquare() === $rule[rtrim($this->getMove()->pgn, '+')]['sq']['current']
            ) {
                return $piece;
            }
        }

        return null;
    }

    /**
     * Calculates the king's travel.
     */
    protected function setTravel(): void
    {
        $travel =  [
            ... (array) $this->rook->getTravel(),
            ... (array) $this->bishop->getTravel()
        ];

        foreach($travel as $key => $val) {
            $travel[$key] = $val[0] ?? null;
        }

        $this->travel = (object) array_filter(array_unique($travel));
    }

    /**
     * Gets the king's legal moves.
     *
     * @return mixed array|null
     */
    public function getSqs(): ?array
    {
        $sqs = [
            ...$this->sqsKing(),
            ...$this->sqsCaptures(),
            ...[$this->sqCastleLong()],
            ...[$this->sqCastleShort()]
        ];

        return array_filter($sqs);
    }

    public function getDefendedSqs(): ?array
    {
        $sqs = [];
        foreach ($this->travel as $sq) {
            if (in_array($sq, $this->board->getSqEval()->used->{$this->getColor()})) {
                $sqs[] = $sq;
            }
        }

        return $sqs;
    }
}
