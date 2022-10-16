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
                        $this->play($clone, $color, Castle::SHORT, $legal);
                    } elseif ($sq === $rule[Castle::LONG]['sq']['next'] &&
                        $piece->sqCastleLong()
                    ) {
                        $this->play($clone, $color, Castle::LONG, $legal);
                    } else {
                        $this->play($clone, $color, Piece::K.$sq, $legal);
                        $this->play($clone, $color, Piece::K.'x'.$sq, $legal);
                    }
                } elseif ($id === Piece::P) {
                    $this->play($clone, $color, $sq, $legal);
                    $this->play($clone, $color, $piece->getFile()."x$sq", $legal);
                } else {
                    if (in_array($sq, $this->disambiguation($color, $id))) {
                        $this->play($clone, $color, $id.$position.$sq, $legal);
                        $this->play($clone, $color, "{$id}{$position}x$sq", $legal);
                    } else {
                        $this->play($clone, $color, $id.$sq, $legal);
                        $this->play($clone, $color, "{$id}x{$sq}", $legal);
                    }
                }
            }
        }

        return [
            $color => $this->find($legal),
        ];
    }

    protected function play($clone, $color, $str, &$legal)
    {
        try {
            if ($clone->play($color, $str)) {
                $legal[] = [
                    $str => (new BoardToStr($clone))->create()
                ];
            }
        } catch (\Exception $e) {

        }
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
