<?php
include('definitions.php');

/**
 * Created by PhpStorm.
 * User: Etienne
 * Date: 17.08.2015
 * Time: 21:44
 */
class Solver extends Storage
{
    public function solve()
    {
        foreach ($_SESSION['sudokuGrid'] as $rowValue => $row) {
            foreach ($row as $fieldValue => $field) {
                if ($field === null) {
                    $possibleEntries = [];
                    for ($counter = 1; $counter <= 9; $counter++) {
                        if ($this->checkIfPossible($rowValue, $fieldValue, $field)) {
                            $possibleEntries[] = $counter;
                        }
                    }
                    if (count($possibleEntries) === 1) {
                        $_SESSION['sudokuGrid'][$rowValue][$fieldValue] = $possibleEntries[0];
                    }
                }
            }
        }
    }
}