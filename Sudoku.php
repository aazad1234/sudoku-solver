<?php

class Sudoku
{
    public array $board;

    public function __construct()
    {
        $this->board = array_fill(0, 9, array_fill(0, 9, 0));
    }

    public function generateFull(): void
    {
        $this->solve();
    }

    public function makePuzzle(int $remove = 45): void
    {
        while ($remove > 0) {
            $r = rand(0, 8);
            $c = rand(0, 8);
            if ($this->board[$r][$c] !== 0) {
                $this->board[$r][$c] = 0;
                $remove--;
            }
        }
    }

    public function solve(): bool
    {
        for ($r = 0; $r < 9; $r++) {
            for ($c = 0; $c < 9; $c++) {
                if ($this->board[$r][$c] === 0) {
                    $nums = range(1, 9);
                    shuffle($nums);
                    foreach ($nums as $n) {
                        if ($this->isSafe($r, $c, $n)) {
                            $this->board[$r][$c] = $n;
                            if ($this->solve()) return true;
                            $this->board[$r][$c] = 0;
                        }
                    }
                    return false;
                }
            }
        }
        return true;
    }

    private function isSafe(int $r, int $c, int $n): bool
    {
        for ($i = 0; $i < 9; $i++) {
            if ($this->board[$r][$i] === $n) return false;
            if ($this->board[$i][$c] === $n) return false;
        }

        $sr = $r - $r % 3;
        $sc = $c - $c % 3;

        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->board[$sr + $i][$sc + $j] === $n) return false;
            }
        }

        return true;
    }
}
