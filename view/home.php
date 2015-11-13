<main>
    <h2>Welcome to our Sudoku-solver</h2>
    <aside id="favorites">
        <h3>Saved sudokus</h3>
        <?php
        if (isset($_SESSION['user'])) {
            $data = $database->getSudokusOfUser($_SESSION['user']['userID']);
            if (count($data)) {
                ?>
                <table id="sudoku-table">
                    <?php
                    foreach ($data as $key => $entry) {
                        echo '<tr><td><a href="./?page=sudoku&sudokuId=' . $entry['sudokuID'] . '">' . $entry['sudokuName'] . '</a></td></tr>';
                    }
                    ?>
                </table>
            <?php
            } else {
                echo 'you don\'t have any saved sudokus';
            }
        } else {
            echo 'please log in to see your sudokus';
        }
        ?>
    </aside>
</main>