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
        if(!isset($_SESSION['sudokuGrid'])){
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
        foreach ($_SESSION['sudokuGrid'] as $row) {
            if ($row[$fieldValue] === (int)$value) {
                return false;
            }
        }

        return true;
    }
}