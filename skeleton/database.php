<?php

class Database
{
    /**
     * @param $username
     * @param $password
     * @param $password2
     * @return bool
     */
    public function registerUser($username, $password, $password2)
    {
        if ($password !== $password2) {
            return false;
        }
        $mysqli = new mysqli("localhost", "root", "", "sudokuSolver");
        $sql = "INSERT INTO sudokuSolver.users (username, password) VALUES ('$username', '$password')";
        $result = $mysqli->query($sql);
        $mysqli->close();
        return json_encode(['status' => !!$result ? 1 : 0, 'message' => !!$result ? 'success' : 'error']);
    }

    public function saveSudokuForUser($userId, $sudokuData, $sudokuName)
    {
        $mysqli = new mysqli("localhost", "root", "", "sudokuSolver");
        $sql = "INSERT INTO sudokuSolver.userSudoku (userID, sudokuData, sudokuName) VALUES ($userId, '$sudokuData', '$sudokuName')";
        $result = $mysqli->query($sql);
        $mysqli->close();
        return json_encode(['status' => !!$result ? 1 : 0, 'message' => !!$result ? 'success' : 'error']);
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
        $mysqli->close();
        return $result->fetch_assoc();
    }

    public function loginUser($username, $password)
    {
        $mysqli = new mysqli("localhost", "root", "", "sudokuSolver");
        $sql = "SELECT * FROM sudokuSolver.users WHERE username = '$username' AND password = '$password'";
        $result = $mysqli->query($sql)->fetch_assoc();
        $_SESSION['user'] = $result;
        return json_encode(['status' => !!$result ? 1 : 0, 'message' => !!$result ? 'success' : 'error']);
    }
}

$database = new Database;