<?php

class database
{
    /**
     * @param $username
     * @param $password
     */
    public function registerUser($username, $password)
    {
        $mysqli = new mysqli("localhost", "root", "", "sudokuSolver");
        $sql = "INSERT INTO sudokuSolver.users (username, password) VALUES ('$username', '$password')";
        $mysqli->query($sql);
        $mysqli->close();
    }

    public function saveSudokuForUser($userId, $sudokuData)
    {
        $mysqli = new mysqli("localhost", "root", "", "sudokuSolver");
        $sql = "INSERT INTO sudokuSolver.userSudoku (userID, sudokuData) VALUES ($userId, $sudokuData)";
        $mysqli->query($sql);
        $mysqli->close();
    }

    /**
     * @param $userId
     * @return array
     */
    public function getSudokusOfUser($userId)
    {
        $mysqli = new mysqli("localhost", "root", "", "sudokuSolver");
        $sql = "SELECT * FROM sudokuSolver.userSudoku WHERE userID = $userId";
        $result = $mysqli->query($sql);
        $sudokus = array();
        while ($row = $result ? $result->fetch_assoc() : 0) {
            $sudokus[] = $row;
        }
        $mysqli->close();
        return $sudokus;
    }

    public function getSudokuDataByID($sudokuID)
    {
        $mysqli = new mysqli("localhost", "root", "", "sudokuSolver");
        $sql = "SELECT * FROM sudokuSolver.userSudoku WHERE sudokuID = $sudokuID";
        $result = $mysqli->query($sql);
        $sudokus = array();
        while ($row = $result ? $result->fetch_assoc() : 0) {
            $sudokus[] = $row;
        }
        $mysqli->close();
        return $sudokus[0];
    }
}

$db = new database;