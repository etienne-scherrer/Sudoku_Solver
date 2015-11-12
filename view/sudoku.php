<button type="button" id="sudoku-revert" onclick="caller.revertStep()">One step back</button>
<div id="status-field"></div>
<table id="sudoku-grid">
    <?php
    for ($rows = 0; $rows < 9; $rows++) {
        echo '<tr class="sudoku-row" data-row="' . $rows . '">';
        for ($fields = 0; $fields < 9; $fields++) {
            echo '<td class="sudoku-field" contenteditable="true" data-field="' . $fields . '"></td>';
        }
        echo '</tr>';
    }
    ?>
</table>
<button type="button" id="sudoku-solve" onclick="caller.submitValues()">Solve</button>
<button type="button" id="sudoku-reset" onclick="caller.reset()">Reset</button>
</div>
<script type="text/javascript">caller.init()</script>