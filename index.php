<?php
session_start();
require_once 'Sudoku.php';

/* ===============================
   INIT GAME
================================ */
if (!isset($_SESSION['puzzle']) || isset($_GET['new'])) {
    $s = new Sudoku();
    $s->generateFull();
    $solution = $s->board;

    $s->makePuzzle(45); // Easy level
    $_SESSION['puzzle'] = $s->board;
    $_SESSION['solution'] = $solution;
}

$fixed = $_SESSION['puzzle'];
$board = $_POST['board'] ?? $fixed;

/* ===============================
   SOLVE BUTTON
================================ */
if (isset($_POST['solve'])) {
    $board = $_SESSION['solution'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sudoku Game</title>
    <style>
        body {
            font-family: system-ui, Arial;
            background: #0f172a;
            color: #fff;
            display: flex;
            justify-content: center;
            padding-top: 40px;
        }

        .container {
            background: #020617;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 0 40px rgba(0, 0, 0, .6);
        }

        h2 {
            text-align: center;
            margin-bottom: 16px;
        }

        table {
            border-collapse: collapse;
            margin: auto;
        }

        td {
            border: 1px solid #334155;
        }

        td:nth-child(3),
        td:nth-child(6) {
            border-right: 3px solid #64748b;
        }

        tr:nth-child(3) td,
        tr:nth-child(6) td {
            border-bottom: 3px solid #64748b;
        }

        input {
            width: 48px;
            height: 48px;
            text-align: center;
            font-size: 22px;
            background: #020617;
            color: #fff;
            border: none;
            outline: none;
        }

        .fixed {
            background: #020617;
            color: #38bdf8;
            font-weight: bold;
        }

        .error {
            background: #7f1d1d !important;
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 16px;
        }

        button,
        a {
            padding: 10px 16px;
            background: #38bdf8;
            border: none;
            border-radius: 6px;
            color: #020617;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Sudoku</h2>

        <form method="post">
            <table id="sudoku">
                <?php for ($r = 0; $r < 9; $r++): ?>
                    <tr>
                        <?php for ($c = 0; $c < 9; $c++):
                            $isFixed = $fixed[$r][$c] !== 0;
                        ?>
                            <td>
                                <input
                                    maxlength="1"
                                    name="board[<?= $r ?>][<?= $c ?>]"
                                    value="<?= $board[$r][$c] ?: '' ?>"
                                    <?= $isFixed ? 'readonly class="fixed"' : '' ?>>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </table>

            <div class="actions">
                <button name="solve">Solve</button>
                <a href="?new=1">New Game</a>
            </div>
        </form>
    </div>

    <script>
        const inputs = document.querySelectorAll("#sudoku input");

        inputs.forEach(i => i.addEventListener("input", validate));

        function validate() {
            inputs.forEach(i => i.classList.remove("error"));

            let g = [...Array(9)].map(() => Array(9).fill(0));

            inputs.forEach((i, k) => {
                let r = Math.floor(k / 9);
                let c = k % 9;
                g[r][c] = parseInt(i.value) || 0;
            });

            for (let r = 0; r < 9; r++) {
                for (let c = 0; c < 9; c++) {
                    let v = g[r][c];
                    if (!v) continue;
                    if (!ok(g, r, c, v)) {
                        inputs[r * 9 + c].classList.add("error");
                    }
                }
            }
        }

        function ok(g, r, c, v) {
            for (let i = 0; i < 9; i++) {
                if (i != c && g[r][i] == v) return false;
                if (i != r && g[i][c] == v) return false;
            }
            let sr = r - r % 3,
                sc = c - c % 3;
            for (let i = 0; i < 3; i++)
                for (let j = 0; j < 3; j++)
                    if ((sr + i != r || sc + j != c) && g[sr + i][sc + j] == v) return false;
            return true;
        }
    </script>

</body>

</html>