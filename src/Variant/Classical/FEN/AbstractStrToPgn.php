<?php

namespace Chess\Variant\Classical\FEN;

use Chess\Piece\K;
use Chess\Variant\Classical\PGN\AN\Castle;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\Board;

abstract class AbstractStrToPgn
{
    protected string $fromFen;

    protected string $toFen;

    protected Board $board;

    public function __construct(string $fromFen, string $toFen)
    {
        $this->fromFen = $fromFen;
        $this->toFen = $toFen;
    }

    abstract protected function find(array $legal): ?string;

    public function create(): array
    {
        $legal = [];
        $color = $this->board->getTurn();
        foreach ($this->board->getPiecesByColor($color) as $piece) {
            foreach ($piece->sqs() as $sq) {
                $clone = unserialize(serialize($this->board));
                $id = $piece->getId();
                $position = $piece->getSq();
                if ($id === Piece::K) {
                    $rule = $this->board->getCastlingRule()[$color][Piece::K];
                    if ($sq === $rule[Castle::SHORT]['sq']['next'] &&
                        $piece->sqCastleShort()
                    ) {
                        try {
                            $isPlayed = $clone->play($color, Castle::SHORT);
                            if ($isPlayed) {
                                $legal[] = [
                                    Castle::SHORT => (new BoardToStr($clone))->create()
                                ];
                            }
                        } catch (\Exception $e) {}
                    } elseif ($sq === $rule[Castle::LONG]['sq']['next'] &&
                        $piece->sqCastleLong()
                    ) {
                        try {
                            $isPlayed = $clone->play($color, Castle::LONG);
                            if ($isPlayed) {
                                $legal[] = [
                                    Castle::LONG => (new BoardToStr($clone))->create()
                                ];
                            }
                        } catch (\Exception $e) {}
                    } else {
                        try {
                            $isPlayed = $clone->play($color, Piece::K.$sq);
                            if ($isPlayed) {
                                $legal[] = [
                                    Piece::K.$sq => (new BoardToStr($clone))->create()
                                ];
                            }
                        } catch (\Exception $e) {}
                        try {
                            $isPlayed = $clone->play($color, Piece::K.'x'.$sq);
                            if ($isPlayed) {
                                $legal[] = [
                                    Piece::K.'x'.$sq => (new BoardToStr($clone))->create()
                                ];
                            }
                        } catch (\Exception $e) {}
                    }
                } elseif ($id === Piece::P) {
                    try {
                        $isPlayed = $clone->play($color, $sq);
                        if ($isPlayed) {
                            $legal[] = [
                                $sq => (new BoardToStr($clone))->create()
                            ];
                        }
                    } catch (\Exception $e) {}
                    try {
                        $isPlayed = ($clone->play($color, $piece->getFile()."x$sq"));
                        if ($isPlayed) {
                            $legal[] = [
                                $piece->getFile()."x$sq" => (new BoardToStr($clone))->create()
                            ];
                        }
                    } catch (\Exception $e) {}
                } else {
                    if (in_array($sq, $this->disambiguation($color, $id))) {
                        try {
                            $isPlayed = $clone->play($color, $id.$position.$sq);
                            if ($isPlayed) {
                                $legal[] = [
                                    $id.$position.$sq => (new BoardToStr($clone))->create()
                                ];
                            }
                        } catch (\Exception $e) {}
                        try {
                            $isPlayed = $clone->play($color, "{$id}{$position}x$sq");
                            if ($isPlayed) {
                                $legal[] = [
                                    "{$id}{$position}x$sq" => (new BoardToStr($clone))->create()
                                ];
                            }
                        } catch (\Exception $e) {}
                    } else {
                        try {
                            $isPlayed = $clone->play($color, $id.$sq);
                            if ($isPlayed) {
                                $legal[] = [
                                    $id.$sq => (new BoardToStr($clone))->create()
                                ];
                            }
                        } catch (\Exception $e) {}
                        try {
                            $isPlayed = $clone->play($color, "{$id}x{$sq}");
                            if ($isPlayed) {
                                $legal[] = [
                                    "{$id}x{$sq}" => (new BoardToStr($clone))->create()
                                ];
                            }
                        } catch (\Exception $e) {}
                    }
                }
            }
        }

        return [
            $color => $this->find($legal),
        ];
    }

    protected function disambiguation(string $color, string $id): array
    {
        $ids = [];
        $clone = unserialize(serialize($this->board));
        foreach ($clone->getPiecesByColor($color) as $piece) {
            foreach ($piece->sqs() as $sq) {
                if ($piece->getId() !== Piece::K && $piece->getId() !== Piece::P) {
                    $ids[$piece->getId()][$piece->getSq()][] = $sq;
                }
            }
        }
        $vals = array_merge(...array_values($ids[$id]));
        $duplicates = array_diff_assoc($vals, array_unique($vals));

        return $duplicates;
    }
}
