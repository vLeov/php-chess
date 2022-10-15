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
        try {
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
                            if ($clone->play($color, Castle::SHORT)) {
                                $legal[] = [
                                    Castle::SHORT => (new BoardToStr($clone))->create()
                                ];
                            }
                        } elseif ($sq === $rule[Castle::LONG]['sq']['next'] &&
                            $piece->sqCastleLong()
                        ) {
                            if ($clone->play($color, Castle::LONG)) {
                                $legal[] = [
                                    Castle::LONG => (new BoardToStr($clone))->create()
                                ];
                            }
                        } elseif ($clone->play($color, Piece::K.$sq)) {
                            $legal[] = [
                                Piece::K.$sq => (new BoardToStr($clone))->create()
                            ];
                        } elseif ($clone->play($color, Piece::K.'x'.$sq)) {
                            $legal[] = [
                                Piece::K.'x'.$sq => (new BoardToStr($clone))->create()
                            ];
                        }
                    } elseif ($id === Piece::P) {
                        if ($clone->play($color, $sq)) {
                            $legal[] = [
                                $sq => (new BoardToStr($clone))->create()
                            ];
                        }
                        if ($clone->play($color, $piece->getFile()."x$sq")) {
                            $legal[] = [
                                $piece->getFile()."x$sq" => (new BoardToStr($clone))->create()
                            ];
                        }
                    } else {
                        if (in_array($sq, $this->disambiguation($color, $id))) {
                            if ($clone->play($color, $id.$position.$sq)) {
                                $legal[] = [
                                    $id.$position.$sq => (new BoardToStr($clone))->create()
                                ];
                            } elseif ($clone->play($color, "{$id}{$position}x$sq")) {
                                $legal[] = [
                                    "{$id}{$position}x$sq" => (new BoardToStr($clone))->create()
                                ];
                            }
                        } else {
                            if ($clone->play($color, $id.$sq)) {
                                $legal[] = [
                                    $id.$sq => (new BoardToStr($clone))->create()
                                ];
                            } elseif ($clone->play($color, "{$id}x{$sq}")) {
                                $legal[] = [
                                    "{$id}x{$sq}" => (new BoardToStr($clone))->create()
                                ];
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
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
