<?php

class SudokuSolver_OLD {
    private $board;

    public function __construct($board) {
        $this->board = $board;
    }

    public function solve() {
        return $this->solveSudoku($this->board);
    }

    private function solveSudoku(&$board) {
        $emptyCell = $this->findEmptyCell($board);
        if ($emptyCell === null) {
            return true; // Puzzle solved
        }

        list($row, $col) = $emptyCell;

        for ($num = 1; $num <= 9; $num++) {
            if ($this->isSafe($board, $row, $col, $num)) {
                $board[$row][$col] = $num;
                if ($this->solveSudoku($board)) {
                    return true;
                }
                $board[$row][$col] = 0; // Backtrack
            }
        }

        return false; // No solution found
    }

    private function findEmptyCell(&$board) {
        for ($row = 0; $row < 9; $row++) {
            for ($col = 0; $col < 9; $col++) {
                if ($board[$row][$col] === 0) {
                    return [$row, $col];
                }
            }
        }
        return null; // No empty cell found
    }

    private function isSafe($board, $row, $col, $num) {
        return !$this->usedInRow($board, $row, $num) &&
            !$this->usedInCol($board, $col, $num) &&
            !$this->usedInBox($board, $row - $row % 3, $col - $col % 3, $num);
    }

    private function usedInRow($board, $row, $num) {
        for ($col = 0; $col < 9; $col++) {
            if ($board[$row][$col] === $num) {
                return true;
            }
        }
        return false;
    }

    private function usedInCol($board, $col, $num) {
        for ($row = 0; $row < 9; $row++) {
            if ($board[$row][$col] === $num) {
                return true;
            }
        }
        return false;
    }

    private function usedInBox($board, $startRow, $startCol, $num) {
        for ($row = 0; $row < 3; $row++) {
            for ($col = 0; $col < 3; $col++) {
                if ($board[$row + $startRow][$col + $startCol] === $num) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getBoard() {
        return $this->board;
    }

    public function isBoardValid() {
        for ($r=0;$r<9;$r++) {
            for ($c=0;$c<9;$c++) {
                $v = $this->board[$r][$c];
                if ($v == 0) continue;
                $this->board[$r][$c] = 0;
                if (!$this->isSafe($this->board, $r, $c, $v)) {
                    return false;
                }
                $this->board[$r][$c] = $v;
            }
        }
        return true;
    }

}
?>
