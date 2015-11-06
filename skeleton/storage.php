<?php
include('definitions.php');

/**
 * Created by PhpStorm.
 * User: Etienne
 * Date: 17.08.2015
 * Time: 21:46
 */
class Storage
{
    public function createGrid()
    {
        if (!isset($_SESSION['sudokuGrid'])) {
            $_SESSION['sudokuGrid'] = [];
            for ($rows = 1; $rows <= 9; $rows++) {
                for ($fields = 1; $fields <= 9; $fields++) {
                    $_SESSION['sudokuGrid'][$rows][$fields] = null;
                }
            }
        }

        return json_encode(['status' => 1, 'message' => 'success', 'data' => $_SESSION['sudokuGrid']]);
    }

    public function setField($row, $field, $value)
    {
        $this->makeBlocks();
        if ($this->checkIfPossible($row, $field, $value)) {
            $_SESSION['sudokuGrid'][$row][$field] = (int)$value;

            return json_encode(['status' => 1, 'message' => 'success']);
        }

        return json_encode(['status' => 0, 'message' => 'not possible']);
    }

    public function checkIfPossible($rowValue, $fieldValue, $value)
    {
        if (in_array($value, $_SESSION['sudokuGrid'][$rowValue])) {
            return false;
        }

        foreach ($_SESSION['sudokuBlocks']  as $key => $block) {
            if(array_key_exists($rowValue.$fieldValue, $block) && in_array($value, $block)) {
                return false;
            }
        }


        foreach ($_SESSION['sudokuGrid'] as $row) {
            if ($row[$fieldValue] === (int)$value) {
                return false;
            }
        }

        return true;
    }

    public function makeBlocks()
    {
        $blocks = [];
        $currentBlock = $currentField = $currentRow = 1;
        for ($totalField = 1; $totalField <= 81; $totalField++) {
            if ($currentRow <= 3 && $currentField <= 3) {
                $currentBlock = 1;
            } elseif ($currentRow <= 3 && $currentField <= 6) {
                $currentBlock = 2;
            } elseif ($currentRow <= 3 && $currentField <= 9) {
                $currentBlock = 3;
            } elseif ($currentRow <= 6 && $currentField <= 3) {
                $currentBlock = 4;
            } elseif ($currentRow <= 6 && $currentField <= 6) {
                $currentBlock = 5;
            } elseif ($currentRow <= 6 && $currentField <= 9) {
                $currentBlock = 6;
            } elseif ($currentRow <= 9 && $currentField <= 3) {
                $currentBlock = 7;
            } elseif ($currentRow <= 9 && $currentField <= 6) {
                $currentBlock = 8;
            } elseif ($currentRow <= 9 && $currentField <= 9) {
                $currentBlock = 9;
            }

            $blocks[$currentBlock][$currentRow . $currentField] = $_SESSION['sudokuGrid'][$currentRow][$currentField];
            if ($currentField === 9) {
                $currentField = 1;
                $currentRow++;
            } else {
                $currentField++;
            }
        }
        $_SESSION['sudokuBlocks'] = $blocks;
    }
}