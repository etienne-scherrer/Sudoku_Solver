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
        $possibilityOfRows = [];
//        do {
//            $stop = true;
        foreach ($_SESSION['sudokuGrid'] as $rowValue => $row) {
            foreach ($row as $fieldValue => $field) {
                if ($field === null) {
//                        $stop = false;
                    $possibleEntries = [];
                    for ($counter = 1; $counter <= 9; $counter++) {
                        if ($this->checkIfPossible($rowValue, $fieldValue, $counter)) {
                            $possibleEntries[] = $counter;
                            $possibilityOfRows[$rowValue][$fieldValue][] = $counter;
                        }
                    }

                    //echo($rowValue . $fieldValue . ': ' . print_r($possibleEntries) . '<br>');

                    if (count($possibleEntries) === 1) {
                        $_SESSION['sudokuGrid'][$rowValue][$fieldValue] = $possibleEntries[0];
                    }
                } else {
                    $possibilityOfRows[$rowValue][$fieldValue][] = $field;
                }
            }
        }
        //---------------------------------------------------------------------
        foreach ($possibilityOfRows as $possibilityOfRow) {

            var_dump($possibilityOfRow);
            exit;
        }
        /*All columns*/
        //foreach() {

        //}
        // All boxes
        //foreach(){

        //}
//        } while (!$stop);
    }
}