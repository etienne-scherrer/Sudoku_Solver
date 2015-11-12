<?php
include('definitions.php');
if (isset($_GET['action'])) {
    include('storage.php');
    include('solver.php');
    include('database.php');
    $action = $_GET['action'];
    $storage = new Storage();
    $solver = new Solver();
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
            session_destroy();
    }
}
