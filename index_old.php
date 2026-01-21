<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sudoku Solver</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        .fixed {
            background: #eee;
            font-weight: bold;
        }

        .error {
            background: #ffb3b3 !important;
        }

        td input {
            width: 30px;
            height: 30px;
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <h1>Sudoku Solver</h1>
    <form method="post">
        <table id="sudoku">
            <?php for ($i = 0; $i < 9; $i++): ?>
                <tr>
                    <?php for ($j = 0; $j < 9; $j++):
                        $isFixed = $fixed[$i][$j] != 0;
                    ?>
                        <td>
                            <input
                                type="text"
                                maxlength="1"
                                name="board[<?= $i ?>][<?= $j ?>]"
                                value="<?= $board[$i][$j] ?: '' ?>"
                                class="<?= $isFixed ? 'fixed' : '' ?>"
                                <?= $isFixed ? 'readonly' : '' ?>>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </table>
        <br>
        <input type="submit" value="Solve">
    </form>

    <?php
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     require_once 'sudoku_solver.php';

    //     // Parse the input board from the form
    //     $inputBoard = $_POST['board'];
    //     $parsedBoard = array();
    //     foreach ($inputBoard as $row) {
    //         $parsedRow = array();
    //         foreach ($row as $cell) {
    //             $parsedRow[] = intval($cell);
    //         }
    //         $parsedBoard[] = $parsedRow;
    //     }

    //     $solver = new SudokuSolver($parsedBoard);
    //     if ($solver->solve()) {
    //         echo "<h2>Sudoku Solved Successfully:</h2>";
    //         echo "<table>";
    //         foreach ($solver->getBoard() as $row) {
    //             echo "<tr>";
    //             foreach ($row as $cell) {
    //                 echo "<td>$cell</td>";
    //             }
    //             echo "</tr>";
    //         }
    //         echo "</table>";
    //     } else {
    //         echo "<h2>No solution exists for the Sudoku puzzle.</h2>";
    //     }
    // }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Parse the input board from the form
        $inputBoard = $_POST['board'];
        $parsedBoard = [];

        foreach ($inputBoard as $row) {
            $parsedRow = [];
            foreach ($row as $cell) {
                $parsedRow[] = intval($cell);
            }
            $parsedBoard[] = $parsedRow;
        }

        $solver = new SudokuSolver($parsedBoard);

        // ===============================
        // 🚨 VALIDATE BEFORE SOLVING
        // ===============================
        if (!$solver->isBoardValid()) {
            echo "<h3 style='color:red'>Invalid Sudoku Input. Please fix highlighted cells.</h3>";
        } else {

            // ===============================
            // ✅ SOLVE ONLY IF VALID
            // ===============================
            if ($solver->solve()) {
                echo "<h2>Sudoku Solved Successfully:</h2>";
                echo "<table>";
                foreach ($solver->getBoard() as $row) {
                    echo "<tr>";
                    foreach ($row as $cell) {
                        echo "<td>$cell</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No solution exists for this Sudoku.</h3>";
            }
        }
    }

    ?>

    <script>
        const inputs = document.querySelectorAll("#sudoku input");

        inputs.forEach(inp => {
            inp.addEventListener("input", validateGrid);
        });

        function validateGrid() {
            inputs.forEach(i => i.classList.remove("error"));

            let grid = [...Array(9)].map(() => Array(9).fill(0));

            inputs.forEach((input, idx) => {
                let r = Math.floor(idx / 9);
                let c = idx % 9;
                let v = parseInt(input.value) || 0;
                grid[r][c] = v;
            });

            for (let r = 0; r < 9; r++) {
                for (let c = 0; c < 9; c++) {
                    let v = grid[r][c];
                    if (v === 0) continue;

                    if (!isValid(grid, r, c, v)) {
                        inputs[r * 9 + c].classList.add("error");
                    }
                }
            }
        }

        function isValid(grid, row, col, val) {
            for (let i = 0; i < 9; i++) {
                if (i !== col && grid[row][i] === val) return false;
                if (i !== row && grid[i][col] === val) return false;
            }

            let sr = row - row % 3;
            let sc = col - col % 3;

            for (let r = 0; r < 3; r++)
                for (let c = 0; c < 3; c++)
                    if ((sr + r !== row || sc + c !== col) && grid[sr + r][sc + c] === val)
                        return false;

            return true;
        }
    </script>

</body>

</html>