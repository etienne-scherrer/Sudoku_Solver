<?php
include('definitions.php');
if (isset($_GET['action'])) {
    include('storage.php');
    include('solver.php');
    include('database.php');
    $action = $_GET['action'];
    switch ($action) {
        case 'create':
            echo $storage->createGrid();
            break;
        case 'change':
            echo $storage->setField($_POST['row'], $_POST['field'], $_POST['value']);
            break;
        case 'solve':
            echo $solver->solve();
            break;
        case 'revertStep':
            $_SESSION['sudokuGrid'] = $_SESSION['lastState'];
            echo json_encode(['data' => $_SESSION['lastState']]);
            unset($_SESSION['lastState']);
            break;
        case 'reset':
            unset($_SESSION['sudokuGrid']);
            break;
        case 'register':
            echo $database->registerUser($_POST['username'], md5($_POST['password']), md5($_POST['password2']));
            break;
        case 'login':
            echo $database->loginUser($_POST['username'], md5($_POST['password']));
            break;
        case 'logout':
            unset($_SESSION['user']);
            break;
        case 'saveSudoku':
            echo $database->saveSudokuForUser($_SESSION['user']['userID'], serialize($_POST['sudokuData']), $_POST['sudokuName']);
    }
}
