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
    private $_possibility = [];
    private $_grid = [];

    /**
     * @return string
     */
    public function solve()
    {
//            $stop = true;
//        do {
        foreach ($_SESSION['sudokuGrid'] as $rowKey => $row) {
            foreach ($row as $fieldKey => $fieldValue) {
                if ($fieldValue === null) {
//                        $stop = false;

                    $this->getAllPossibilities($rowKey, $fieldKey);

                    $this->getCorrectFieldValue($rowKey, $fieldKey);
                }
            }
        }
//        } while (!$stop);
        return json_encode(['status' => 1, 'message' => 'success', 'data' => $_SESSION['sudokuGrid']]);
    }

    public function checkIfPossible($rowKey, $fieldKey, $value)
    {
        $possible = false;
        if ($this->isPossibleInRow($rowKey, $value)) {
            $possible = true;
        }

        if ($this->isPossibleInColumn($fieldKey, $value)) {
            $possible = true;
        }

        if ($this->isPossibleInBlock($rowKey, $fieldKey, $value)) {
            $possible = true;
        }

        return $possible;
    }

    public function getAllPossibilities($rowKey, $fieldKey)
    {
        for ($counter = 1; $counter <= 9; $counter++) {
            if ($this->checkIfPossible($rowKey, $fieldKey, $counter)) {
                $this->_possibility[$rowKey][$fieldKey][] = $counter;
            }
        }
    }

    public function getCorrectFieldValue($rowKey, $fieldKey)
    {
        if (count($this->_possibility[$rowKey][$fieldKey]) === 1) {
            $_SESSION['sudokuGrid'][$rowKey][$fieldKey] = $this->_possibility[$rowKey][$fieldKey][0];
            return true;
        }
        foreach ($this->_possibility[$rowKey][$fieldKey] as $possible) {

            for ($rowCounter = 0; $rowCounter < 9; $rowCounter++) {
                if ($_SESSION['sudokuGrid'][$rowKey][$fieldKey] ||
                    !in_array($possible, $this->_possibility[$rowCounter][$fieldKey]) ||
                    $rowCounter !== $rowKey
                ) {
                    break;
                }
            }

            // loop through the current row
            for ($colCounter = 0; $colCounter < 9; $colCounter++) {
                if ($_SESSION['sudokuGrid'][$rowKey][$fieldKey] ||
                    in_array($possible, $this->_possibility[$rowKey][$colCounter]) ||
                    $colCounter === $rowKey
                ) {
                    break;
                }

            }

            $blockRowStart = $this->findBlockStart($rowKey);
            $blockColStart = $this->findBlockStart($fieldKey);

            for ($rowCounter = $blockRowStart; $rowCounter < $blockRowStart + 3; $rowCounter++) {

                for ($blockCounter = $blockColStart; $blockCounter < $blockColStart + 3; $blockCounter++) {

                    if (!$rowCounter === $rowKey || !$blockCounter === $fieldKey) {
                        break;
                    }

                    if ($_SESSION['sudokuGrid'][$rowKey][$rowCounter]) {
                        break;
                    }

                    if (in_array($possible, $this->_possibility[$rowCounter][$blockCounter])) {

                    }

                }
            }
        }
        return true;
    }

    /**
     * @param $rowOrCol
     * @return int
     */
    public function findBlockStart($rowOrCol)
    {
        return (int)floor($rowOrCol / 3) * 3;
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

        for ($rowCounter = $blockRowStart; $rowCounter < $blockRowStart + 3; $rowCounter++) {

            for ($colCounter = $blockColStart; $colCounter < $blockColStart + 3; $colCounter++) {

                if (!$rowCounter === $rowKey || !$colCounter === $fieldKey) {
                    return false;
                }
                if (in_array($value, $this->_possibility[$rowCounter][$colCounter]))
                    return false;
            }
        }

        return true;
    }
}