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
    /**
     * @return string
     */
    public function createGrid()
    {
        if (!isset($_SESSION['sudokuGrid'])) {
            $_SESSION['sudokuGrid'] = [];
            for ($rowKey = 0; $rowKey < 9; $rowKey++) {
                for ($fieldKey = 0; $fieldKey < 9; $fieldKey++) {
                    $_SESSION['sudokuGrid'][$rowKey][$fieldKey] = null;
                }
            }
        }

        return json_encode(['status' => 1, 'message' => 'success', 'data' => $_SESSION['sudokuGrid']]);
    }

    /**
     * @param integer $rowKey
     * @param integer $fieldKey
     * @param integer $value
     * @return string
     */
    public function setField($rowKey, $fieldKey, $value)
    {
        $successReturn = json_encode(['status' => 1, 'message' => 'success']);
        $errorReturn = json_encode(['status' => 0, 'message' => 'not possible']);

        if (!$this->isValidInput($value)) {
            return $errorReturn;
        }

        if (!$this->hasInputChanged($rowKey, $fieldKey, $value)) {
            return $errorReturn;
        }

        $solver = new Solver();
        if ($solver->checkIfPossible($rowKey, $fieldKey, $value)) {
            $_SESSION['sudokuGrid'][$rowKey][$fieldKey] = $value;

            return $successReturn;
        }

        $_SESSION['sudokuGrid'][$rowKey][$fieldKey] = null;

        return $errorReturn;
    }

    public function hasInputChanged($rowKey, $fieldKey, $value)
    {
        if ($value === $_SESSION['sudokuGrid'][$rowKey][$fieldKey]) {
            $_SESSION['sudokuGrid'][$rowKey][$fieldKey] = (int)$value ?: null;
            return false;
        }

        return true;
    }

    public function isValidInput($value)
    {
        return (is_numeric($value) && $value > 0 && $value <= 9 || $value === null);
    }
}
$storage = new Storage();