<?php
include('skeleton/definitions.php');
include('skeleton/head.php');
?>
<div id="content">
    <div id="status-field"></div>
    <table id="sudoku-grid">
        <?php
        for ($rows = 1; $rows <= 9; $rows++) {
            echo '<tr class="sudoku-row" data-row="' . $rows . '">';
            for ($fields = 1; $fields <= 9; $fields++) {
                echo '<td class="sudoku-field" contenteditable="true" data-field="' . $fields . '"></td>';
            }
            echo '</tr>';
        }
        ?>
    </table>
    <button type="button" id="sudoku-solve" onclick="caller.submitValues()">Solve</button>
    <button type="button" id="sudoku-test" onclick="caller.test()">Test</button>
</div>
<script type="text/javascript">caller.init()</script>
