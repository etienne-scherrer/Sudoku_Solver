<?php
include('definitions.php');

/**
 * Created by PhpStorm.
 * User: Etienne
 * Date: 17.08.2015
 * Time: 21:44
 */
class Solver
{
    /**
     * @return string
     */
    public function solve()
    {
        $_SESSION['lastState'] = $_SESSION['sudokuGrid'];
//        do {
        foreach ($_SESSION['sudokuGrid'] as $rowKey => $row) {
            foreach ($row as $fieldKey => $fieldValue) {
                if ($fieldValue === null) {
                    $this->getAllPossibilities();
                    $this->getCorrectFieldValue($rowKey, $fieldKey);
                }
            }
        }
//        } while (!$this->allFieldsSolved());
        return json_encode(['status' => 1, 'message' => 'success', 'data' => $_SESSION['sudokuGrid']]);
    }

    public function checkIfPossible($rowKey, $fieldKey, $value)
    {
        if (!$this->isPossibleInRow($rowKey, $value)) {
            return false;
        }

        if (!$this->isPossibleInColumn($fieldKey, $value)) {
            return false;
        }

        if (!$this->isPossibleInBlock($rowKey, $fieldKey, $value)) {
            return false;
        }

        return true;
    }

    public function getAllPossibilities()
    {
        $_SESSION['possibility'] = [];
        foreach ($_SESSION['sudokuGrid'] as $rowKey => $row) {
            foreach ($row as $fieldKey => $fieldValue) {
                if ($fieldValue === null) {
                    for ($value = 1; $value <= 9; $value++) {
                        if ($this->checkIfPossible($rowKey, $fieldKey, $value)) {
                            $_SESSION['possibility'][$rowKey][$fieldKey][] = $value;
                        }
                    }
                }
            }
        }
    }

    public function getCorrectFieldValue($rowKey, $fieldKey)
    {
        if (!isset($_SESSION['possibility'][$rowKey][$fieldKey])) {
            return false;
        }
        if (count($_SESSION['possibility'][$rowKey][$fieldKey]) === 1) {
            $_SESSION['sudokuGrid'][$rowKey][$fieldKey] = $_SESSION['possibility'][$rowKey][$fieldKey][0];
            return true;
        }
        foreach ($_SESSION['possibility'][$rowKey][$fieldKey] as $possible) {

            if ($this->getPossibleAmountOfRow($fieldKey, $possible) === 1) {
                $_SESSION['sudokuGrid'][$rowKey][$fieldKey] = $possible;
                return true;
            }

            if ($this->getPossibleAmountOfColumn($rowKey, $possible) === 1) {
                $_SESSION['sudokuGrid'][$rowKey][$fieldKey] = $possible;
                return true;
            }

            if ($this->getPossibleAmountOfBlock($rowKey, $fieldKey, $possible) === 1) {
                $_SESSION['sudokuGrid'][$rowKey][$fieldKey] = $possible;
                return true;
            }
        }
        return false;
    }

    /**
     * @param $rowOrCol
     * @return int
     */
    public function findBlockStart($rowOrCol)
    {
        return ((int)floor($rowOrCol / 3) * 3);
    }

    /**
     * @param $rowKey
     * @param $value
     * @return bool
     */
    private function isPossibleInRow($rowKey, $value)
    {
        return !in_array($value, $_SESSION['sudokuGrid'][$rowKey]);
    }

    /**
     * @param $fieldKey
     * @param $value
     * @return bool
     */
    public function isPossibleInColumn($fieldKey, $value)
    {
        foreach ($_SESSION['sudokuGrid'] as $row) {
            if ($row[$fieldKey] === (int)$value) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $rowKey
     * @param $fieldKey
     * @param $value
     * @return bool
     */
    public function isPossibleInBlock($rowKey, $fieldKey, $value)
    {
        $blockRowStart = $this->findBlockStart($rowKey);
        $blockColStart = $this->findBlockStart($fieldKey);

        for ($colCounter = $blockColStart; $colCounter < $blockColStart + 3; $colCounter++) {

            for ($rowCounter = $blockRowStart; $rowCounter < $blockRowStart + 3; $rowCounter++) {

                if ($value === $_SESSION['sudokuGrid'][$rowCounter][$colCounter]) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getPossibleAmountOfColumn($fieldKey, $possible)
    {
        $possibleAmount = 0;
        for ($rowCounter = 0; $rowCounter < 9; $rowCounter++) {
            if (isset($_SESSION['possibility'][$rowCounter][$fieldKey])) {
                if (in_array($possible, $_SESSION['possibility'][$rowCounter][$fieldKey])) {
                    $possibleAmount += 1;
                }
            }
        }

        return $possibleAmount;
    }

    public function getPossibleAmountOfRow($rowKey, $possible)
    {
        $possibleAmount = 0;
        for ($colCounter = 0; $colCounter < 9; $colCounter++) {
            if (isset($_SESSION['possibility'][$rowKey][$colCounter])) {
                if (in_array($possible, $_SESSION['possibility'][$rowKey][$colCounter])) {
                    $possibleAmount += 1;
                }
            }
        }

        return $possibleAmount;
    }

    public function getPossibleAmountOfBlock($rowKey, $fieldKey, $possible)
    {
        $blockRowStart = $this->findBlockStart($rowKey);
        $blockColStart = $this->findBlockStart($fieldKey);
        $possibleAmount = 0;

        for ($rowCounter = $blockRowStart; $rowCounter < $blockRowStart + 3; $rowCounter++) {

            for ($blockCounter = $blockColStart; $blockCounter < $blockColStart + 3; $blockCounter++) {

                if (isset($_SESSION['possibility'][$rowCounter][$blockCounter])) {
                    if (in_array($possible, $_SESSION['possibility'][$rowCounter][$blockCounter])) {
                        $possibleAmount += 1;
                    }
                }
            }
        }

        return $possibleAmount;
    }
}
$solver = new Solver();