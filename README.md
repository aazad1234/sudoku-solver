# Sudoku Solver

This is a PHP script that solves Sudoku puzzles using a backtracking algorithm.

## How to Use

1. **Input Sudoku Puzzle**: Input the Sudoku puzzle you want to solve. Use numbers from 1 to 9 to represent the initial puzzle cells, and use `0` or empty cells to represent the cells to be filled.

2. **Submit**: Click on the "Solve" button to solve the Sudoku puzzle.

3. **View Solution**: After submitting the puzzle, the solved Sudoku puzzle will be displayed below the input form.

## Instructions

- Input the Sudoku puzzle by filling in the numbers into the cells of the table.
- Use `0` or leave the cell empty for cells to be filled by the solver.
- After inputting the puzzle, click on the "Solve" button to find the solution.
- The solved Sudoku puzzle will be displayed below the input form.

## Example

Here is an example of how to input a Sudoku puzzle:

5 3 0 0 7 0 0 0 0
6 0 0 1 9 5 0 0 0
0 9 8 0 0 0 0 6 0
8 0 0 0 6 0 0 0 3
4 0 0 8 0 3 0 0 1
7 0 0 0 2 0 0 0 6
0 6 0 0 0 0 2 8 0
0 0 0 4 1 9 0 0 5
0 0 0 0 8 0 0 7 9

Replace `0` with the numbers given in the Sudoku puzzle.

## Notes

- This solver uses a backtracking algorithm to find the solution.
- Ensure that the input Sudoku puzzle is valid and has only one solution.
