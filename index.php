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
    </style>
</head>

<body>
    <h1>Sudoku Solver</h1>
    <form method="post">
        <table>
            <?php
            $board = isset ($_POST['board']) ? $_POST['board'] : array_fill(0, 9, array_fill(0, 9, 0));

            for ($i = 0; $i < 9; $i++) {
                echo "<tr>";
                for ($j = 0; $j < 9; $j++) {
                    echo "<td><input type='text' name='board[$i][$j]' size='1' maxlength='1' value='{$board[$i][$j]}'></td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <input type="submit" value="Solve">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once 'sudoku_solver.php';

        // Parse the input board from the form
        $inputBoard = $_POST['board'];
        $parsedBoard = array();
        foreach ($inputBoard as $row) {
            $parsedRow = array();
            foreach ($row as $cell) {
                $parsedRow[] = intval($cell);
            }
            $parsedBoard[] = $parsedRow;
        }

        $solver = new SudokuSolver($parsedBoard);
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
            echo "<h2>No solution exists for the Sudoku puzzle.</h2>";
        }
    }
    ?>
</body>

</html>